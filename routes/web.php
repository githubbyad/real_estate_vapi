<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyImageController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\InquiryController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\OwnerController;

Route::get('/', function () {
    return view('welcome');
});

// Property CRUD
Route::resource('properties', PropertyController::class);

// Contact form submission
Route::post('/inquiries', [InquiryController::class, 'store'])->name('inquiries.store');

// Authentication routes (Laravel Breeze or similar setup)
Auth::routes();

Route::delete('/property-images/{id}', [PropertyImageController::class, 'destroy']);
Route::post('/property-images/reorder', [PropertyImageController::class, 'reorder'])->name('property-images.reorder');

// Agent Routes
Route::resource('agents', AgentController::class);

// Owner Routes
Route::resource('owners', OwnerController::class);

// Route for uploading agent profile picture
Route::post('/agents/{agent}/upload-profile-picture', [AgentController::class, 'uploadProfilePicture'])->name('agents.uploadProfilePicture');

// Inquiry Routes
Route::resource('inquiries', InquiryController::class)->only(['index', 'show', 'store', 'edit', 'update']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Dashboard route
Route::prefix('manage')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('auth.dashboard');
    })->name('dashboard');
});