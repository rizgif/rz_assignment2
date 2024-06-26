<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BucketsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReportController;

use App\Models\User;



Route::get('/', function () {
  return view('auth/login');
})->name('login'); // Assign the name 'login' to thsis route


// The route now only has 'auth' and 'verified' middleware without 'is_approved'
Route::get('/dashboard', function () {
  return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Group with 'auth' middleware
Route::middleware(['auth'])->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
  Route::get('/reports', function () {
    return view('reports');
  })->name('reports');
  Route::get('/transactions', function () {
    return view('transactions');
  })->name('transactions');
  Route::get('/buckets-data', [BucketsController::class, 'index'])->name('buckets-data');

  Route::get('/buckets/create', [BucketsController::class, 'create'])->name('buckets.create');
  Route::get('/buckets/{id}/edit', [BucketsController::class, 'edit'])->name('buckets.edit');
  Route::put('/buckets/{id}', [BucketsController::class, 'update'])->name('buckets.update');
  Route::delete('/buckets/{bucket}', [BucketsController::class, 'destroy'])->name('buckets.destroy');


  // Route::get('/buckets-data', function () {
  //         return view('buckets-data'); 
  //     })->name('buckets-data');
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
  // Any other routes that require the user to be approved can still be added here.



  Route::get('reports', [ReportController::class, 'index'])->name('reports');
  Route::get('reports/generate', [ReportController::class, 'generate'])->name('reports.generate'); // Define the route for generating reports

});











// Admin routes
Route::middleware(['auth'])->group(function () {
  Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
  Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users');
  Route::post('/admin/users/{user}/approve', [AdminController::class, 'approve'])->name('admin.users.approve');
  Route::post('/admin/users/{user}/reject', [AdminController::class, 'reject'])->name('admin.users.reject');
});


// Auth routes
require __DIR__ . '/auth.php';
