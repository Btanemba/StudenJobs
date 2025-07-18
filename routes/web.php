<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SearchController;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Auth\Events\Verified;
use App\Http\Controllers\Admin\UserCrudController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('home');
})->name('home');


Route::get('admin/login', function () {
    if (Auth::check()) {
        // Redirect authenticated users only to the dashboard if logged in
        return redirect()->route('/admin/dashboard');
    }
    return view('auth.login');
})->name('admin.login');

// Route::get('admin/login', function () {
//     return redirect('/'); // Redirect to your homepage or another page
// })->name('backpack.auth.login');


Route::post('/register', [RegisteredUserController::class, 'store'])
     ->middleware(['guest']);

// Email Verification Route
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');


Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    $user = User::findOrFail($id);
    if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        return abort(403);
    }
    if (!$user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
        event(new Verified($user));
    }
    return redirect('/login')->with('status', 'Your email has been verified. Please log in.');
})->middleware(['signed'])->name('verification.verify');


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

//require __DIR__.'/auth.php';

Route::get('/', [SearchController::class, 'index'])->name('home');
