<?php

namespace App\Auth\Controllers;

use App\Framework\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:1', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', 'min:8', Rules\Password::defaults()],
        ]);

        if (!is_array($validated)) {
            abort(422, 'Validation failed');
        }

        $name = $validated['name'] ?? '';
        $email = $validated['email'] ?? '';
        $password = $validated['password'] ?? '';

        $user = User::create([
            'name' => is_scalar($name) ? strval($name) : '',
            'email' => is_scalar($email) ? strval($email) : '',
            'password' => Hash::make(is_scalar($password) ? strval($password) : ''),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('home', absolute: false));
    }
}
