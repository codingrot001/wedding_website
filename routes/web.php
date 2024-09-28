<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [AdminController::class, 'welcome']);


Route::get('/dashboard', [AdminController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Admin Dashboard Route
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('admin.dashboard');

// Manage uploads routes
Route::get('/uploads', [AdminController::class, 'manageUploads'])
    ->middleware(['auth', 'verified'])
    ->name('admin.uploads.index');

Route::post('/uploads/store', [UploadController::class, 'store'])->name('upload.store');

Route::delete('/uploads/{upload}', [UploadController::class, 'destroy'])
    ->middleware(['auth', 'verified'])
    ->name('admin.uploads.destroy');



// Manage settings route
Route::get('/settings', [AdminController::class, 'settings'])
    ->middleware(['auth', 'verified'])
    ->name('admin.settings.index');

Route::post('/settings/update', [AdminController::class, 'updateSettings'])
    ->name('admin.settings.update');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';