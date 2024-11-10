@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1.25rem;">Editar Categoría</h1>

    <!-- Formulario de edición -->
    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Necesario para una actualización de recurso -->

        <div style="display: grid; grid-template-columns: repeat(1, 1fr); gap: 1.5rem;">
            <!-- Nombre de la Categoría -->
            <div style="display: flex; flex-direction: column;">
                <label for="name" style="font-size: 0.875rem; font-weight: 500;">Nombre de la Categoría</label>
                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required
                    style="border: 1px solid #ddd; padding: 0.5rem; border-radius: 0.375rem; width: 100%;" placeholder="Nombre de la categoría">
                @error('name') 
                    <div class="text-red-600 text-sm mt-2">La categoría ya se encuentra registrada</div> 
                @enderror
            </div>
        </div>

        <!-- Botones de Acción -->
        <div style="margin-top: 1.5rem; display: flex; justify-content: flex-end;">
            <button type="submit" style="background-color: #1D4ED8; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#1E40AF'" onmouseout="this.style.backgroundColor='#1D4ED8'">Actualizar Categoría</button>
        </div>
    </form>
</div>
@endsection
