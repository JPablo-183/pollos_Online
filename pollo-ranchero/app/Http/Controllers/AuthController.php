<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

public function store(Request $request): RedirectResponse
{
    $credenciales = $request->validate([
        'nombre_usuario' => ['required', 'string'],
        'password' => ['required', 'string'],
    ]);

    if (Auth::attempt($credenciales)) {
        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    return back()
        ->withErrors([
            'nombre_usuario' => 'El usuario o la contraseña no son correctos.',
        ])
        ->onlyInput('nombre_usuario');
}
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}