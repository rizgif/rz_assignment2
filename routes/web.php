<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AdminController;


Route::get('/', function () {
    return view('auth/login'); // Assuming 'welcome' is your login page
});

// The route now only has 'auth' and 'verified' middleware without 'is_approved'
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Group with 'auth' middleware
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Any other routes that required the user to be approved can still be added here.
});

Route::get('/transactions', function () {
    return view('transactions'); 
})->name('transactions');

Route::get('/buckets-data', function () {
    return view('buckets-data'); 
})->name('buckets-data');

Route::get('/reports', function () {
    return view('reports'); 
})->name('reports');

Route::get('/upload-form', function () {
    return view('upload-form'); 
})->name('upload-form');

Route::get('/upload', [UploadController::class, 'showUploadForm'])->name('upload.form');
Route::post('/upload', [UploadController::class, 'upload'])->name('upload');

Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
Route::get('/transactions/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');

Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users');
Route::post('/admin/users/{user}/approve', [AdminController::class, 'approve'])->name('admin.users.approve');
Route::post('/admin/users/{user}/reject', [AdminController::class, 'reject'])->name('admin.users.reject');






Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    
});






require __DIR__.'/auth.php';
