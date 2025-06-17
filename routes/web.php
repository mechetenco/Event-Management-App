<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\ApiTokenAuthenticated;




Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('events/{id}', [EventController::class, 'show'])->name('events.show');

// Authenticated routes (create, store, edit, update, delete)
Route::middleware([ApiTokenAuthenticated::class])->group(function () {
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{id}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{id}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');
    Route::post('/events/{id}/attendees', [EventController::class, 'attend'])->name('events.attend');
Route::delete('/events/{eventId}/attendees/{attendeeId}', [EventController::class, 'unattend'])->name('events.unattend');



});




Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.login.form');

Route::post('/login', [AuthController::class, 'login'])->name('login');
// Show forgot form
Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('forgot.form');

// Handle sending reset link
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('forgot');

// Show the password reset form
Route::get('/reset-password-form/{token}', [AuthController::class, 'showResetForm'])->name('reset.form');

// Handle new password submission
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



