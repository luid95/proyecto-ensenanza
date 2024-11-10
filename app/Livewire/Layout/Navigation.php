<?php

namespace App\Livewire\Layout;

use Livewire\Component;

class Navigation extends Component
{
    /**
     * Método para cerrar sesión
     */
    public function logout(Logout $logout)
    {
        // Llama al logout desde el servicio que creaste
        $logout();

        // Redirige al login después de cerrar sesión
        return redirect('/login');
    }
    
    public function render()
    {
        return view('livewire.layout.navigation');
    }
}
