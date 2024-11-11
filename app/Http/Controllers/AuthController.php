<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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
            return redirect()->route('dashboard');
        }

        // Si la autenticación falla, vuelve al formulario con un mensaje de error
        return back()->withErrors(['email' => 'Las credenciales no son correctas.']);
    }

    // Manejar el cierre de sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    // Muestra el formulario de registro
    public function showRegisterForm()
    {
        return view('auth.register'); // Asegúrate de tener la vista 'auth.register' creada
    }

    // Método para manejar el registro de usuarios
    public function register(Request $request)
    {
        // Validación de los datos recibidos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // Asegúrate de tener un campo 'password_confirmation'
            'role' => 'required|in:admin,user', // Validación para el campo 'role'
        ]);

        // Crear un nuevo usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Asegúrate de encriptar la contraseña
            'role' => $request->role, // Asignar el rol
        ]);

        // Opción para iniciar sesión automáticamente después del registro (opcional)
        Auth::login($user);

        // Redirigir al usuario a la página principal o dashboard después de registrarse
        return redirect()->route('login')->with('success', '¡Registro exitoso!');
    }
}
