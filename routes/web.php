<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\AdminUploadController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SettingsController;  // Import the new SettingsController

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

// Public routes
Route::get('/uploads', [UploadController::class, 'create'])->name('upload.create');
Route::post('/uploads', [UploadController::class, 'store'])->name('upload.store');
Route::get('/', [UploadController::class, 'index'])->name('uploads.index');

// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Admin Uploads
    Route::get('/uploads', [AdminUploadController::class, 'index'])->name('admin.uploads.index'); // Updated route name
    Route::delete('/uploads/{upload}', [AdminUploadController::class, 'destroy'])->name('admin.uploads.destroy'); // Ensure this route is correctly named

    // Admin Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('admin.settings.index');
    Route::post('/settings/update', [SettingsController::class, 'update'])->name('admin.settings.update');
});

// Test email route
Route::get('send-test-email', function () {
    \Illuminate\Support\Facades\Mail::raw('This is a test email', function ($message) {
        $message->to('codingrot001@gmail.com')->subject('Test Email');
    });

    return 'Email sent successfully!';
});