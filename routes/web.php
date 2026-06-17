<?php

use Illuminate\Support\Facades\Route;

// Auth Routes (Dummy UI)
Route::get('/login', function () { return view('auth.login'); })->name('login');
Route::get('/register', function () { return view('auth.register'); })->name('register');

Route::get('/', function () {
    return redirect()->route('login');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () { return view('admin.dashboard'); })->name('dashboard');
    Route::get('/users', function () { return view('admin.users'); })->name('users');
    Route::get('/officers', function () { return view('admin.officers'); })->name('officers');
    Route::get('/categories', function () { return view('admin.categories'); })->name('categories');
    Route::get('/inventory', function () { return view('admin.inventory'); })->name('inventory');
    Route::get('/requests', function () { return view('admin.requests'); })->name('requests');
    Route::get('/reports', function () { return view('admin.reports'); })->name('reports');
    Route::get('/statistics', function () { return view('admin.statistics'); })->name('statistics');
    Route::get('/profile', function () { return view('admin.profile'); })->name('profile');
});

// Officer Routes
Route::prefix('officer')->name('officer.')->group(function () {
    Route::get('/', function () { return view('officer.dashboard'); })->name('dashboard');
    Route::get('/inventory', function () { return view('officer.inventory'); })->name('inventory');
    Route::get('/incoming-requests', function () { return view('officer.incoming_requests'); })->name('incoming_requests');
    Route::get('/borrowed', function () { return view('officer.borrowed'); })->name('borrowed');
    Route::get('/returns', function () { return view('officer.returns'); })->name('returns');
    Route::get('/reports', function () { return view('officer.reports'); })->name('reports');
    Route::get('/profile', function () { return view('officer.profile'); })->name('profile');
});

// Student Routes
Route::prefix('student')->name('student.')->group(function () {
    Route::get('/', function () { return view('student.dashboard'); })->name('dashboard');
    Route::get('/inventory', function () { return view('student.inventory'); })->name('inventory');
    Route::get('/borrow', function () { return view('student.borrow'); })->name('borrow');
    Route::get('/my-borrowings', function () { return view('student.my_borrowings'); })->name('my_borrowings');
    Route::get('/history', function () { return view('student.history'); })->name('history');
    Route::get('/returns', function () { return view('student.returns'); })->name('returns');
    Route::get('/download-pdf', function () { return view('student.download_pdf'); })->name('download_pdf');
    Route::get('/profile', function () { return view('student.profile'); })->name('profile');
});
