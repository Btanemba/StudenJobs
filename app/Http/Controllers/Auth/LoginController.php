<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Fortify\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Fortify;

class LoginController extends Controller
{
    /**
     * Handle a login request to the application.
     *
     * @param  \Laravel\Fortify\Http\Requests\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        // Attempt to authenticate the user
        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $request->session()->regenerate();

            // Load the authenticated user's person relationship
            $user = Auth::user()->load('person');

             if (!$user->hasVerifiedEmail()) {

            return redirect()->route('verification.notice');
        }

            // Check if first_name, last_name, and gender exist
            if (
                !$user->person ||
                empty($user->person->first_name) ||
                empty($user->person->last_name)

            ) {
                return redirect(route('user.edit', $user->id));
            }

            // Update last_access timestamp
            $user->update(['last_access' => now()]);

            // Redirect to the admin user dashboard
            return redirect('admin/dashboard');
        }

        // If authentication fails, redirect back with error
        return back()->withErrors([
            'email' => __('auth.failed'),
        ])->onlyInput('email');
    }

    /**
     * Show the login view.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }
}
