<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SearchController;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Auth\Events\Verified;
use App\Http\Controllers\Admin\UserCrudController;
use Illuminate\Support\Facades\Auth;

// Home Route
Route::get('/', [SearchController::class, 'index'])->name('home');

// Admin Login Route
Route::get('admin/login', function () {
    if (Auth::check()) {
        return redirect()->route('admin.dashboard');
    }
    return view('auth.login');
})->name('admin.login');

// Custom Login Routes
// Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [LoginController::class, 'login']);

// Registration Routes
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->middleware(['guest']);

// Email Verification Routes
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    $user = User::findOrFail($id);
    if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        return abort(403);
    }
    if (!$user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
        event(new Verified($user));
    }
    return redirect()->route('login')->with('status', 'Your email has been verified. Please log in.');
})->middleware(['signed'])->name('verification.verify');

 Route::get('/admin/dashboard', function () {
    return view('vendor.backpack.ui.dashboard');
})->middleware(['auth', 'verified'])->name('admin.dashboard');

Route::get('/terms', function () {
    return view('terms');
})->name('terms');
Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');
