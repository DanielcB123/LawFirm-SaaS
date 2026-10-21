<?php

namespace App\Http\Controllers\Tenant\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerificationController extends Controller
{
    public function show(): RedirectResponse|\Illuminate\Contracts\View\View
    {
        return request()->user()->hasVerifiedEmail()
            ? redirect()->intended(RouteServiceProvider::HOME)
            : view('tenant.auth.verify');
    }

    public function verify(EmailVerificationRequest $request): RedirectResponse
    {
        if (! $request->user()->hasVerifiedEmail()) {
            $request->fulfill();
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function resend(): RedirectResponse
    {
        if (! request()->user()->hasVerifiedEmail()) {
            request()->user()->sendEmailVerificationNotification();
        }

        return back()->with('resent', true);
    }

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
}
