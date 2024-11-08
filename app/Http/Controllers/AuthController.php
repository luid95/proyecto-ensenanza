<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AuthController extends Controller
{
    // Mostrar el formulario de inicio de sesión
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Manejar el inicio de sesión
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            // Si la autenticación tiene éxito, redirige a la página de inicio
            return redirect()->route('home');
        }

        // Si la autenticación falla, vuelve al formulario con un mensaje de error
        return back()->withErrors(['email' => 'Las credenciales no son correctas.']);
    }

    // Manejar el cierre de sesión
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
