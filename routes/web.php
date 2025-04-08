<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('admin/login', function () {
    if (Auth::check()) {
        // Redirect authenticated users only to the dashboard if logged in
        return redirect()->route('dashboard');
    }
    return view('auth.login');
})->name('admin.login');

// Route::get('admin/login', function () {
//     return redirect('/'); // Redirect to your homepage or another page
// })->name('backpack.auth.login');


Route::post('/register', [RegisteredUserController::class, 'store'])
     ->middleware(['guest']);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

//require __DIR__.'/auth.php';
