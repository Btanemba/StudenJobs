<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Fortify;

class RegisteredUserController extends Controller
{
    public function __construct(protected StatefulGuard $guard) {}

    public function create(Request $request)
    {
        return view('auth.register');
    }

    public function store(Request $request, CreatesNewUsers $creator)
    {
        if (config('fortify.lowercase_usernames')) {
            $request->merge([
                Fortify::username() => Str::lower($request->{Fortify::username()}),
            ]);
        }

        // Create the user
        $user = $creator->create($request->all());

        event(new Registered($user));

        // ❌ Do NOT log the user in
        // $this->guard->login($user, $request->boolean('remember'));

        // ✅ Redirect to login page
        return redirect()->route('login')->with('status', 'Registration successful! Please Check Email for Verification.');
    }
}
