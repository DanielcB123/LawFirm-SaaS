<?php

namespace App\Http\Controllers\Tenant\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ConfirmPasswordController extends Controller
{
    public function showConfirmForm()
    {
        return view('tenant.auth.passwords.confirm');
    }

    public function confirm(Request $request): RedirectResponse
    {
        $request->validate(['password' => ['required', 'string']]);

        if (! Hash::check($request->password, $request->user()->password)) {
            return back()->withErrors(['password' => __('auth.password')]);
        }

        $request->session()->put('auth.password_confirmed_at', time());

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function __construct()
    {
        $this->middleware('auth');
    }
}
