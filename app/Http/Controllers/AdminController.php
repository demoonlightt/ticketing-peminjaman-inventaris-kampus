<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\MahasiswaProfile;
use App\Models\OfficerProfile;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\BorrowRequest;
use App\Models\BorrowRequestItem;

class AdminController extends Controller
{
    /**
     * Admin Dashboard with analytical data.
     */
    public function dashboard()
    {
        $totalInventory = Inventory::sum('total_stock');
        $totalUser = User::where('role', 'student')->count();
        $activeBorrowings = BorrowRequest::where('status', 'borrowed')->count();
        
        $startOfMonth = now()->startOfMonth()->toDateString();
        $endOfMonth = now()->endOfMonth()->toDateString();
        $monthlyRequests = BorrowRequest::whereBetween('request_date', [$startOfMonth, $endOfMonth])->count();

        // 1. Monthly borrowing trends (Last 6 Months)
        $trends = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthLabel = $month->format('M');
            $count = BorrowRequest::whereYear('request_date', $month->year)
                ->whereMonth('request_date', $month->month)
                ->count();
            $trends['labels'][] = $monthLabel;
            $trends['data'][] = $count;
        }

        // 2. Condition distribution
        $conditions = [
            'baik' => Inventory::where('condition', 'baik')->sum('total_stock'),
            'rusak_ringan' => Inventory::where('condition', 'rusak_ringan')->sum('total_stock'),
            'rusak_berat' => Inventory::where('condition', 'rusak_berat')->sum('total_stock'),
        ];

        // 3. Top utilized items (ratio of borrowed / total stock)
        // We can look at active borrowings to compute utilization
        $utilizationItems = Inventory::select('name', 'total_stock', 'available_stock')
            ->orderBy('total_stock', 'desc')
            ->take(5)
            ->get();

        $utilization = [
            'labels' => [],
            'data' => []
        ];

        foreach ($utilizationItems as $item) {
            $utilization['labels'][] = $item->name;
            $borrowed = $item->total_stock - $item->available_stock;
            $rate = $item->total_stock > 0 ? round(($borrowed / $item->total_stock) * 100) : 0;
            $utilization['data'][] = $rate;
        }

        return view('admin.dashboard', compact(
            'totalInventory',
            'totalUser',
            'activeBorrowings',
            'monthlyRequests',
            'trends',
            'conditions',
            'utilization'
        ));
    }

    /**
     * User/Student Management.
     */
    public function users(Request $request)
    {
        $search = $request->input('search');
        $query = User::where('role', 'student')->with('mahasiswaProfile');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('mahasiswaProfile', function($qp) use ($search) {
                      $qp->where('nim', 'like', "%{$search}%");
                  });
            });
        }

        $users = $query->get();
        return view('admin.users', compact('users', 'search'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'nim' => 'required|string|max:20|unique:mahasiswa_profiles,nim',
            'email' => 'required|email|max:150|unique:users,email',
            'prodi' => 'required|string|max:100',
            'fakultas' => 'required|string|max:100',
            'angkatan' => 'required|numeric',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('mahasiswa123'),
            'role' => 'student',
            'status' => 'active',
        ]);

        MahasiswaProfile::create([
            'user_id' => $user->id,
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'fakultas' => $request->fakultas,
            'angkatan' => $request->angkatan,
        ]);

        return redirect()->route('admin.users')->with('success', 'Mahasiswa berhasil ditambahkan dengan password bawaan: mahasiswa123');
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $profile = MahasiswaProfile::where('user_id', $id)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:100',
            'nim' => 'required|string|max:20|unique:mahasiswa_profiles,nim,' . $profile->id,
            'email' => 'required|email|max:150|unique:users,email,' . $user->id,
            'prodi' => 'required|string|max:100',
            'fakultas' => 'required|string|max:100',
            'angkatan' => 'required|numeric',
            'status' => 'required|in:active,suspended',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
        ]);

        $profile->update([
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'fakultas' => $request->fakultas,
            'angkatan' => $request->angkatan,
        ]);

        return redirect()->route('admin.users')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = $user->status === 'active' ? 'suspended' : 'active';
        $user->save();

        return redirect()->route('admin.users')->with('success', 'Status akun berhasil diubah.');
    }

    public function resetUserPassword($id)
    {
        $user = User::findOrFail($id);
        $user->password = Hash::make('mahasiswa123');
        $user->save();

        return redirect()->route('admin.users')->with('success', 'Password berhasil di-reset ke: mahasiswa123');
    }

    /**
     * Officer Management.
     */
    public function officers(Request $request)
    {
        $search = $request->input('search');
        $query = User::where('role', 'officer')->with('officerProfile');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('officerProfile', function($qp) use ($search) {
                      $qp->where('employee_number', 'like', "%{$search}%");
                  });
            });
        }

        $officers = $query->get();
        return view('admin.officers', compact('officers', 'search'));
    }

    public function storeOfficer(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'employee_number' => 'required|string|max:30|unique:officer_profiles,employee_number',
            'email' => 'required|email|max:150|unique:users,email',
            'division' => 'required|string|max:100',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('petugas123'),
            'role' => 'officer',
            'status' => 'active',
        ]);

        OfficerProfile::create([
            'user_id' => $user->id,
            'employee_number' => $request->employee_number,
            'division' => $request->division,
        ]);

        return redirect()->route('admin.officers')->with('success', 'Petugas berhasil ditambahkan dengan password bawaan: petugas123');
    }

    public function updateOfficer(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $profile = OfficerProfile::where('user_id', $id)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:100',
            'employee_number' => 'required|string|max:30|unique:officer_profiles,employee_number,' . $profile->id,
            'email' => 'required|email|max:150|unique:users,email,' . $user->id,
            'division' => 'required|string|max:100',
            'status' => 'required|in:active,suspended',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
        ]);

        $profile->update([
            'employee_number' => $request->employee_number,
            'division' => $request->division,
        ]);

        return redirect()->route('admin.officers')->with('success', 'Data petugas berhasil diperbarui.');
    }

    /**
     * Categories Management.
     */
    public function categories()
    {
        $categories = Category::withCount('inventories')->get();
        return view('admin.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        Category::create($request->all());

        return redirect()->route('admin.categories')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update($request->all());

        return redirect()->route('admin.categories')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);
        if ($category->inventories()->count() > 0) {
            return redirect()->route('admin.categories')->with('error', 'Kategori tidak dapat dihapus karena masih memiliki barang inventaris.');
        }

        $category->delete();
        return redirect()->route('admin.categories')->with('success', 'Kategori berhasil dihapus.');
    }

    /**
     * Inventory Management.
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
        $categories = Category::all();
        return view('admin.inventory', compact('inventories', 'categories', 'search'));
    }

    public function storeInventory(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'code' => 'required|string|max:50|unique:inventories,code',
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'total_stock' => 'required|integer|min:0',
            'location' => 'required|string|max:150',
            'condition' => 'required|in:baik,rusak_ringan,rusak_berat',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('image');
        $data['available_stock'] = $request->total_stock;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('inventory', 'public');
            $data['image'] = $path;
        }

        Inventory::create($data);

        return redirect()->route('admin.inventory')->with('success', 'Barang inventaris berhasil ditambahkan.');
    }

    public function updateInventory(Request $request, $id)
    {
        $inventory = Inventory::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'code' => 'required|string|max:50|unique:inventories,code,' . $inventory->id,
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'total_stock' => 'required|integer|min:0',
            'location' => 'required|string|max:150',
            'condition' => 'required|in:baik,rusak_ringan,rusak_berat',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('image');
        
        // Adjust available stock if total stock changes
        $stockDiff = $request->total_stock - $inventory->total_stock;
        $data['available_stock'] = max(0, $inventory->available_stock + $stockDiff);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('inventory', 'public');
            $data['image'] = $path;
        }

        $inventory->update($data);

        return redirect()->route('admin.inventory')->with('success', 'Barang inventaris berhasil diperbarui.');
    }

    public function destroyInventory($id)
    {
        $inventory = Inventory::findOrFail($id);
        if ($inventory->borrowRequestItems()->count() > 0) {
            return redirect()->route('admin.inventory')->with('error', 'Barang tidak dapat dihapus karena memiliki riwayat peminjaman.');
        }

        $inventory->delete();
        return redirect()->route('admin.inventory')->with('success', 'Barang inventaris berhasil dihapus.');
    }

    /**
     * Request Monitoring.
     */
    public function requests(Request $request)
    {
        $status = $request->input('status');
        $month = $request->input('month');

        $query = BorrowRequest::with(['student', 'approvedBy', 'items.inventory', 'handover', 'returnRecord.fine']);

        if ($status) {
            $query->where('status', $status);
        }

        if ($month) {
            $query->where('request_date', 'like', "{$month}%");
        }

        $requests = $query->orderBy('id', 'desc')->get();
        return view('admin.requests', compact('requests', 'status', 'month'));
    }

    /**
     * Reports generation.
     */
    public function reports(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $status = $request->input('status');

        $query = BorrowRequest::with(['student', 'approvedBy', 'items.inventory', 'handover', 'returnRecord.fine']);

        if ($startDate) {
            $query->whereDate('request_date', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('request_date', '<=', $endDate);
        }
        if ($status) {
            $query->where('status', $status);
        }

        $reports = $query->get();

        return view('admin.reports', compact('reports', 'startDate', 'endDate', 'status'));
    }

    /**
     * Admin Statistics.
     */
    public function statistics()
    {
        // Summary stats
        $totalFines = DB::table('fines')->sum('amount');
        $unpaidFines = DB::table('fines')->where('paid_status', 'unpaid')->sum('amount');
        $paidFines = DB::table('fines')->where('paid_status', 'paid')->sum('amount');

        $conditions = [
            'baik' => Inventory::where('condition', 'baik')->count(),
            'rusak_ringan' => Inventory::where('condition', 'rusak_ringan')->count(),
            'rusak_berat' => Inventory::where('condition', 'rusak_berat')->count(),
        ];

        $categories = Category::withCount('inventories')->get();

        // Top 5 active students
        $topStudents = User::where('role', 'student')
            ->with('mahasiswaProfile')
            ->withCount('borrowRequests')
            ->orderBy('borrow_requests_count', 'desc')
            ->take(5)
            ->get();

        // Officer Performance (This month)
        $officersPerformance = User::where('role', 'officer')
            ->with('officerProfile')
            ->withCount([
                'handovers' => function($q) {
                    $q->whereMonth('handover_date', date('m'))
                      ->whereYear('handover_date', date('Y'));
                },
                'returns' => function($q) {
                    $q->whereMonth('return_date', date('m'))
                      ->whereYear('return_date', date('Y'));
                }
            ])
            ->get();

        return view('admin.statistics', compact(
            'totalFines',
            'unpaidFines',
            'paidFines',
            'conditions',
            'categories',
            'topStudents',
            'officersPerformance'
        ));
    }

    /**
     * Admin profile.
     */
    public function profile()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.profile')->with('success', 'Profil Anda berhasil diperbarui.');
    }
}
