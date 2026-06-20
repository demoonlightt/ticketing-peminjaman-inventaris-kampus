<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OfficerController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\GoogleController;

// Auth Routes (Login, Register, Logout)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Google Authentication Routes
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// Password Reset Routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Dev Quick Role Switcher (local only)
Route::get('/dev/switch-role/{role}', [AuthController::class, 'devSwitchRole'])->name('dev.switch-role');
Route::any('/dev/test-upload', [AuthController::class, 'devTestUpload'])->name('dev.test-upload');

Route::get('/', [AuthController::class, 'showLogin']);

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', function() { return redirect()->route('admin.dashboard'); });
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // User (Student) Management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::post('/users/{id}/toggle', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
    Route::post('/users/{id}/reset', [AdminController::class, 'resetUserPassword'])->name('users.reset-password');

    // Officer Management
    Route::get('/officers', [AdminController::class, 'officers'])->name('officers');
    Route::post('/officers', [AdminController::class, 'storeOfficer'])->name('officers.store');
    Route::put('/officers/{id}', [AdminController::class, 'updateOfficer'])->name('officers.update');

    // Category Management
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::put('/categories/{id}', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminController::class, 'destroyCategory'])->name('categories.destroy');

    // Inventory Management
    Route::get('/inventory', [AdminController::class, 'inventory'])->name('inventory');
    Route::post('/inventory', [AdminController::class, 'storeInventory'])->name('inventory.store');
    Route::put('/inventory/{id}', [AdminController::class, 'updateInventory'])->name('inventory.update');
    Route::delete('/inventory/{id}', [AdminController::class, 'destroyInventory'])->name('inventory.destroy');

    // Requests Monitoring
    Route::get('/requests', [AdminController::class, 'requests'])->name('requests');
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::get('/statistics', [AdminController::class, 'statistics'])->name('statistics');
    
    // Profile
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::post('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');
});

Route::prefix('officer')->name('officer.')->middleware(['auth', 'role:officer'])->group(function () {
    Route::get('/', function() { return redirect()->route('officer.dashboard'); });
    Route::get('/dashboard', [OfficerController::class, 'dashboard'])->name('dashboard');
    Route::get('/inventory', [OfficerController::class, 'inventory'])->name('inventory');
    
    // Loan requests processing
    Route::get('/incoming-requests', [OfficerController::class, 'incomingRequests'])->name('incoming_requests');
    Route::post('/requests/{id}/approve', [OfficerController::class, 'approveRequest'])->name('requests.approve');
    Route::post('/requests/{id}/reject', [OfficerController::class, 'rejectRequest'])->name('requests.reject');
    
    // Handovers (Approved requests)
    Route::get('/borrowed', [OfficerController::class, 'borrowed'])->name('borrowed');
    Route::post('/requests/{id}/handover', [OfficerController::class, 'recordHandover'])->name('requests.handover');
    
    // Returns & Fines
    Route::get('/returns', [OfficerController::class, 'returns'])->name('returns');
    Route::post('/requests/{id}/return', [OfficerController::class, 'recordReturn'])->name('requests.return');
    Route::post('/fines/{id}/pay', [OfficerController::class, 'payFine'])->name('fines.pay');
    
    // Reports
    Route::get('/reports', [OfficerController::class, 'reports'])->name('reports');
    
    // Profile
    Route::get('/profile', [OfficerController::class, 'profile'])->name('profile');
    Route::post('/profile', [OfficerController::class, 'updateProfile'])->name('profile.update');
});

Route::prefix('student')->name('student.')->middleware(['auth', 'role:student'])->group(function () {
    Route::get('/', function() { return redirect()->route('student.dashboard'); });
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/inventory', [StudentController::class, 'inventory'])->name('inventory');
    
    // Borrow checkout
    Route::get('/borrow', [StudentController::class, 'showBorrowForm'])->name('borrow');
    Route::post('/borrow', [StudentController::class, 'storeBorrowRequest'])->name('borrow.store');
    
    // Requests tracking
    Route::get('/my-borrowings', [StudentController::class, 'myBorrowings'])->name('my_borrowings');
    Route::get('/history', [StudentController::class, 'history'])->name('history');
    Route::get('/returns', [StudentController::class, 'returns'])->name('returns');
    
    // Documents
    Route::get('/download-pdf', [StudentController::class, 'downloadPdfPage'])->name('download_pdf');
    Route::get('/receipt/{id}/export', [StudentController::class, 'exportReceipt'])->name('receipt.export');
    Route::get('/history/export', [StudentController::class, 'exportHistory'])->name('history.export');
    
    // Profile
    Route::get('/profile', [StudentController::class, 'profile'])->name('profile');
    Route::post('/profile', [StudentController::class, 'updateProfile'])->name('profile.update');
});
