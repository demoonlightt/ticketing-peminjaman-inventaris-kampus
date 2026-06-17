<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\OfficerProfile;
use App\Models\Inventory;
use App\Models\BorrowRequest;
use App\Models\BorrowRequestItem;
use App\Models\Handover;
use App\Models\ReturnRecord;
use App\Models\Fine;

class OfficerController extends Controller
{
    /**
     * Officer Dashboard.
     */
    public function dashboard()
    {
        $totalInventory = Inventory::sum('total_stock');
        $incomingRequests = BorrowRequest::where('status', 'pending')->count();
        $activeBorrowings = BorrowRequest::where('status', 'borrowed')->count();
        
        $today = date('Y-m-d');
        $returnsToday = ReturnRecord::whereDate('return_date', $today)->count();
        
        $lateCount = BorrowRequest::where('status', 'borrowed')
            ->where('return_date', '<', $today)
            ->count();

        // Recent pending & approved requests
        $recentRequests = BorrowRequest::with(['student', 'items.inventory'])
            ->whereIn('status', ['pending', 'approved', 'borrowed'])
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        return view('officer.dashboard', compact(
            'totalInventory',
            'incomingRequests',
            'activeBorrowings',
            'returnsToday',
            'lateCount',
            'recentRequests'
        ));
    }

    /**
     * Inventory list.
     */
    public function inventory(Request $request)
    {
        $search = $request->input('search');
        $query = Inventory::with('category');
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        $inventories = $query->get();
        return view('officer.inventory', compact('inventories'));
    }

    /**
     * Incoming requests.
     */
    public function incomingRequests()
    {
        $requests = BorrowRequest::with(['student.mahasiswaProfile', 'items.inventory'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'asc')
            ->get();
        return view('officer.incoming_requests', compact('requests'));
    }

    public function approveRequest(Request $request, $id)
    {
        $borrowRequest = BorrowRequest::findOrFail($id);

        if ($borrowRequest->status !== 'pending') {
            return redirect()->route('officer.incoming_requests')->with('error', 'Pengajuan sudah diproses sebelumnya.');
        }

        // Validate stock for all items
        foreach ($borrowRequest->items as $item) {
            if ($item->inventory->available_stock < $item->quantity) {
                return redirect()->route('officer.incoming_requests')->with('error', "Stok barang '{$item->inventory->name}' tidak mencukupi (Tersedia: {$item->inventory->available_stock}, Diminta: {$item->quantity}).");
            }
        }

        DB::transaction(function() use ($borrowRequest) {
            // Deduct stock
            foreach ($borrowRequest->items as $item) {
                $item->inventory->decrement('available_stock', $item->quantity);
            }

            // Update request
            $borrowRequest->update([
                'status' => 'approved',
                'approved_by' => Auth::id(),
            ]);
        });

        return redirect()->route('officer.incoming_requests')->with('success', 'Pengajuan peminjaman berhasil disetujui.');
    }

    public function rejectRequest(Request $request, $id)
    {
        $borrowRequest = BorrowRequest::findOrFail($id);

        if ($borrowRequest->status !== 'pending') {
            return redirect()->route('officer.incoming_requests')->with('error', 'Pengajuan sudah diproses sebelumnya.');
        }

        $borrowRequest->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
        ]);

        return redirect()->route('officer.incoming_requests')->with('success', 'Pengajuan peminjaman ditolak.');
    }

    /**
     * Handover management (Currently Borrowed or Approved).
     */
    public function borrowed()
    {
        // Get requests that are either approved (ready to pick up) or currently borrowed (active)
        $requests = BorrowRequest::with(['student.mahasiswaProfile', 'items.inventory', 'handover'])
            ->whereIn('status', ['approved', 'borrowed'])
            ->get();
        return view('officer.borrowed', compact('requests'));
    }

    public function recordHandover(Request $request, $id)
    {
        $borrowRequest = BorrowRequest::findOrFail($id);

        if ($borrowRequest->status !== 'approved') {
            return redirect()->route('officer.borrowed')->with('error', 'Barang belum disetujui atau sudah diserahterimakan.');
        }

        $request->validate([
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function() use ($borrowRequest, $request) {
            Handover::create([
                'borrow_request_id' => $borrowRequest->id,
                'officer_id' => Auth::id(),
                'handover_date' => date('Y-m-d'),
                'notes' => $request->notes,
            ]);

            $borrowRequest->update([
                'status' => 'borrowed',
            ]);
        });

        return redirect()->route('officer.borrowed')->with('success', 'Penyerahan barang berhasil dicatat. Status sekarang: Dipinjam.');
    }

    /**
     * Returns processing page.
     */
    public function returns()
    {
        $borrowedRequests = BorrowRequest::with(['student.mahasiswaProfile', 'items.inventory', 'handover'])
            ->where('status', 'borrowed')
            ->get();

        $returnedRequests = BorrowRequest::with(['student.mahasiswaProfile', 'items.inventory', 'returnRecord.fine'])
            ->where('status', 'returned')
            ->get();

        return view('officer.returns', compact('borrowedRequests', 'returnedRequests'));
    }

    public function recordReturn(Request $request, $id)
    {
        $borrowRequest = BorrowRequest::findOrFail($id);

        if ($borrowRequest->status !== 'borrowed') {
            return redirect()->route('officer.returns')->with('error', 'Pengajuan ini tidak sedang dalam status dipinjam.');
        }

        $request->validate([
            'return_date' => 'required|date',
            'item_condition' => 'required|in:baik,rusak_ringan,rusak_berat',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function() use ($borrowRequest, $request) {
            $returnDate = strtotime($request->return_date);
            $dueDate = strtotime($borrowRequest->return_date);
            
            $lateDays = 0;
            $fineAmount = 0.00;
            $fineReasonParts = [];

            // Calculate late fine
            if ($returnDate > $dueDate) {
                $diff = $returnDate - $dueDate;
                $lateDays = max(0, round($diff / (60 * 60 * 24)));
                $lateFine = $lateDays * 5000;
                $fineAmount += $lateFine;
                $fineReasonParts[] = "Terlambat mengembalikan {$lateDays} hari (Rp " . number_format($lateFine, 0, ',', '.') . ")";
            }

            // Calculate damage fine
            if ($request->item_condition === 'rusak_ringan') {
                $fineAmount += 50000;
                $fineReasonParts[] = "Kerusakan ringan pada barang (Rp 50.000)";
            } elseif ($request->item_condition === 'rusak_berat') {
                $fineAmount += 150000;
                $fineReasonParts[] = "Kerusakan berat pada barang (Rp 150.000)";
            }

            // Create return record
            $returnRecord = ReturnRecord::create([
                'borrow_request_id' => $borrowRequest->id,
                'officer_id' => Auth::id(),
                'return_date' => $request->return_date,
                'item_condition' => $request->item_condition,
                'late_days' => $lateDays,
                'notes' => $request->notes,
            ]);

            // Create fine record if any fine accumulated
            if ($fineAmount > 0) {
                Fine::create([
                    'return_id' => $returnRecord->id,
                    'amount' => $fineAmount,
                    'reason' => implode(' dan ', $fineReasonParts) . '.',
                    'paid_status' => 'unpaid',
                ]);
            }

            // Restore inventory stock level
            foreach ($borrowRequest->items as $item) {
                $item->inventory->increment('available_stock', $item->quantity);
                
                // If returned damaged, we might want to update the condition of the asset itself?
                // Let's update it if the returned condition is worse
                if ($request->item_condition !== 'baik' && $item->inventory->condition === 'baik') {
                    $item->inventory->update(['condition' => $request->item_condition]);
                }
            }

            // Update borrow request status
            $borrowRequest->update([
                'status' => 'returned',
            ]);
        });

        return redirect()->route('officer.returns')->with('success', 'Pengembalian barang berhasil diproses.');
    }

    public function payFine($fine_id)
    {
        $fine = Fine::findOrFail($fine_id);
        $fine->update(['paid_status' => 'paid']);

        return redirect()->route('officer.returns')->with('success', 'Denda berhasil dibayarkan.');
    }

    /**
     * Reports viewer.
     */
    public function reports(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = BorrowRequest::with(['student', 'items.inventory', 'handover', 'returnRecord.fine'])
            ->whereIn('status', ['borrowed', 'returned']);

        if ($startDate) {
            $query->whereDate('request_date', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('request_date', '<=', $endDate);
        }

        $reports = $query->get();

        return view('officer.reports', compact('reports', 'startDate', 'endDate'));
    }

    /**
     * Officer Profile.
     */
    public function profile()
    {
        $user = Auth::user()->load('officerProfile');
        return view('officer.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $profile = OfficerProfile::where('user_id', $user->id)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email,' . $user->id,
            'employee_number' => 'required|string|max:30|unique:officer_profiles,employee_number,' . $profile->id,
            'division' => 'required|string|max:100',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        $profile->update([
            'employee_number' => $request->employee_number,
            'division' => $request->division,
        ]);

        return redirect()->route('officer.profile')->with('success', 'Profil Anda berhasil diperbarui.');
    }
}
