<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\MahasiswaProfile;
use App\Models\Inventory;
use App\Models\Category;
use App\Models\BorrowRequest;
use App\Models\BorrowRequestItem;
use App\Models\ReturnRecord;
use App\Models\Fine;

class StudentController extends Controller
{
    /**
     * Student Dashboard.
     */
    public function dashboard()
    {
        $studentId = Auth::id();
        
        $totalAvailableStock = Inventory::sum('available_stock');
        $activeBorrowingsCount = BorrowRequest::where('student_id', $studentId)
            ->where('status', 'borrowed')
            ->count();
        $totalRequestsCount = BorrowRequest::where('student_id', $studentId)->count();
        
        $pendingRequestsCount = BorrowRequest::where('student_id', $studentId)
            ->where('status', 'pending')
            ->count();
            
        $lateRequestsCount = BorrowRequest::where('student_id', $studentId)
            ->where('status', 'borrowed')
            ->where('return_date', '<', date('Y-m-d'))
            ->count();
            
        // Sum of unpaid fines for this student
        $unpaidFines = Fine::whereHas('returnRecord.borrowRequest', function($q) use ($studentId) {
            $q->where('student_id', $studentId);
        })->where('paid_status', 'unpaid')->sum('amount');

        // Active borrowings list (including pending for request tracking)
        $activeBorrowings = BorrowRequest::with(['items.inventory', 'handover'])
            ->where('student_id', $studentId)
            ->whereIn('status', ['pending', 'approved', 'borrowed'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('student.dashboard', compact(
            'totalAvailableStock',
            'activeBorrowingsCount',
            'totalRequestsCount',
            'pendingRequestsCount',
            'lateRequestsCount',
            'unpaidFines',
            'activeBorrowings'
        ));
    }

    /**
     * Inventory catalog with category filtering.
     */
    public function inventory(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category_id');

        $query = Inventory::with('category');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $inventories = $query->get();
        $categories = Category::all();

        return view('student.inventory', compact('inventories', 'categories', 'search', 'categoryId'));
    }

    /**
     * Show borrowing request form.
     */
    public function showBorrowForm(Request $request)
    {
        $selectedInventoryId = $request->input('inventory_id');
        $inventories = Inventory::where('available_stock', '>', 0)
            ->where('condition', 'baik')
            ->get();

        return view('student.borrow', compact('inventories', 'selectedInventoryId'));
    }

    /**
     * Submit borrowing request.
     */
    public function storeBorrowRequest(Request $request)
    {
        $request->validate([
            'inventory_id' => 'required|exists:inventories,id',
            'quantity' => 'required|integer|min:1',
            'borrow_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after:borrow_date',
            'purpose' => 'required|string',
            'attachment' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ], [
            'borrow_date.after_or_equal' => 'Tanggal pinjam tidak boleh di masa lalu.',
            'return_date.after' => 'Tanggal kembali harus setelah tanggal pinjam.',
            'attachment.max' => 'Ukuran file surat pengantar maksimal adalah 2MB.'
        ]);

        // Validate stock
        $inventory = Inventory::findOrFail($request->inventory_id);
        if ($inventory->available_stock < $request->quantity) {
            return back()->withErrors(['quantity' => "Stok '{$inventory->name}' tidak mencukupi (Tersedia: {$inventory->available_stock})."])
                ->withInput();
        }

        DB::transaction(function() use ($request) {
            $attachmentPath = null;
            if ($request->hasFile('attachment')) {
                $attachmentPath = $request->file('attachment')->store('attachments', 'public');
            }

            // Create Borrow Request
            $borrowRequest = BorrowRequest::create([
                'student_id' => Auth::id(),
                'request_date' => date('Y-m-d'),
                'borrow_date' => $request->borrow_date,
                'return_date' => $request->return_date,
                'purpose' => $request->purpose,
                'attachment' => $attachmentPath,
                'status' => 'pending',
            ]);

            // Create Borrow Request Item
            BorrowRequestItem::create([
                'borrow_request_id' => $borrowRequest->id,
                'inventory_id' => $request->inventory_id,
                'quantity' => $request->quantity,
            ]);
        });

        return redirect()->route('student.my_borrowings')->with('success', 'Pengajuan peminjaman berhasil dikirim. Menunggu persetujuan petugas.');
    }

    /**
     * My Borrowings.
     */
    public function myBorrowings()
    {
        $requests = BorrowRequest::with(['items.inventory', 'approvedBy', 'handover'])
            ->where('student_id', Auth::id())
            ->whereIn('status', ['pending', 'approved', 'borrowed'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('student.my_borrowings', compact('requests'));
    }

    /**
     * History of borrowings.
     */
    public function history()
    {
        $requests = BorrowRequest::with(['items.inventory', 'approvedBy', 'returnRecord.fine'])
            ->where('student_id', Auth::id())
            ->whereIn('status', ['returned', 'rejected'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('student.history', compact('requests'));
    }

    /**
     * Returns view for student.
     */
    public function returns()
    {
        // Fetch borrowed requests for this student
        $requests = BorrowRequest::with(['items.inventory', 'handover'])
            ->where('student_id', Auth::id())
            ->where('status', 'borrowed')
            ->get();

        return view('student.returns', compact('requests'));
    }

    /**
     * Show download documents page.
     */
    public function downloadPdfPage()
    {
        $studentId = Auth::id();
        
        // Active and completed requests for select inputs
        $activeRequests = BorrowRequest::with('items.inventory')
            ->where('student_id', $studentId)
            ->whereIn('status', ['approved', 'borrowed'])
            ->get();

        return view('student.download_pdf', compact('activeRequests'));
    }

    /**
     * Export a specific borrowing receipt (invoice format printable).
     */
    public function exportReceipt($id)
    {
        $borrowRequest = BorrowRequest::with(['student.mahasiswaProfile', 'items.inventory', 'handover', 'approvedBy'])
            ->where('student_id', Auth::id())
            ->findOrFail($id);

        return view('student.receipt_pdf', compact('borrowRequest'));
    }

    /**
     * Export complete borrowing history as a printable report.
     */
    public function exportHistory(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $student = Auth::user()->load('mahasiswaProfile');
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $borrowings = BorrowRequest::with(['items.inventory', 'returnRecord.fine'])
            ->where('student_id', $student->id)
            ->whereBetween('request_date', [$startDate, $endDate])
            ->orderBy('request_date', 'asc')
            ->get();

        return view('student.history_pdf', compact('student', 'borrowings', 'startDate', 'endDate'));
    }

    /**
     * Student Profile.
     */
    public function profile()
    {
        $user = Auth::user()->load('mahasiswaProfile');
        return view('student.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $profile = MahasiswaProfile::where('user_id', $user->id)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email,' . $user->id,
            'prodi' => 'required|string|max:100',
            'fakultas' => 'required|string|max:100',
            'angkatan' => 'required|numeric|digits:4',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        $profile->update([
            'prodi' => $request->prodi,
            'fakultas' => $request->fakultas,
            'angkatan' => $request->angkatan,
        ]);

        return redirect()->route('student.profile')->with('success', 'Profil Anda berhasil diperbarui.');
    }
}
