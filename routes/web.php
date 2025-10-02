<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertyImageController;

Route::get('/', function () {
    return view('welcome');
});

// Contact form submission
// Route::post('/inquiries', [InquiryController::class, 'store'])->name('inquiries.store');

// Authentication routes (Laravel Breeze or similar setup)
Auth::routes();

// Route::delete('/property-images/{id}', [PropertyImageController::class, 'destroy']);
// Route::post('/property-images/reorder', [PropertyImageController::class, 'reorder'])->name('property-images.reorder');

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Backend routes with auth middleware
Route::prefix('manage')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('auth.dashboard');
    })->name('dashboard');

    // Property CRUD
    Route::resource('properties', PropertyController::class);

    // Inquiry Routes
    Route::resource('inquiries', InquiryController::class)->only(['index', 'show', 'store', 'edit', 'update']);

    // Agent Routes
    Route::resource('agents', AgentController::class);

    // Owner Routes
    Route::resource('owners', OwnerController::class);

    // Edit Setting 
    Route::get('/settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::post('/settings/update', [SettingController::class, 'update'])->name('settings.update');
});
