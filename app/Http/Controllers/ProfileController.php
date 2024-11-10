<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // Método para mostrar el perfil
    public function show()
    {
        return view('profile');
    }
}
