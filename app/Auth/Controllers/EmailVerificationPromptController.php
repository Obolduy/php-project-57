<?php

namespace App\Auth\Controllers;

use App\Framework\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        $user = $request->user();
        
        if ($user === null) {
            return redirect()->route('login');
        }
        
        return $user->hasVerifiedEmail()
                    ? redirect()->intended(route('home', absolute: false))
                    : view('auth.verify-email');
    }
}
