<?php

namespace App\Http\Controllers\Tenant\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('tenant.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors(['email' => __('auth.failed')]);
        }

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('tenant.login');
    }

    public function __construct()
    {
        $this->middleware('guest')->except(['logout']);
    }
}
