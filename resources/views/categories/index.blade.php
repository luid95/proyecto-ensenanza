@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1.25rem;">Mis Categorías</h1>

    <!-- Formulario de búsqueda -->
    <form method="GET" action="{{ route('categories.index') }}" style="margin-bottom: 1.5rem;">
        <div style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: flex-end;"> <!-- Alineación en la misma línea -->
            <div style="flex: 1 1 23%; display: flex; flex-direction: column;">
                <label for="name" style="font-size: 0.875rem; font-weight: 500;">Nombre de la Categoría</label>
                <input type="text" name="name" id="name" style="border: 1px solid #ddd; padding: 0.5rem; border-radius: 0.375rem; width: 100%;" placeholder="Buscar por nombre" value="{{ request('name') }}">
            </div>

            <div style="flex: 1 1 auto;">
                <button type="submit" style="background-color: #1D4ED8; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#1E40AF'" onmouseout="this.style.backgroundColor='#1D4ED8'">Buscar</button>
                <!-- Botón para limpiar filtros -->
                <a href="{{ route('categories.index') }}" style="background-color: #1D4ED8; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; transition: background-color 0.3s; display: inline-block;" onmouseover="this.style.backgroundColor='#1E40AF'" onmouseout="this.style.backgroundColor='#1D4ED8'">Limpiar Filtros</a>
            </div>
        </div>
    </form>

    <!-- Botón para agregar nueva categoría -->
    @if(auth()->user()->isAdmin())
        <div style="text-align: right; margin-top: 1.5rem;">
            <a href="{{ route('categories.create') }}" style="background-color: #1D4ED8; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#1E40AF'" onmouseout="this.style.backgroundColor='#1D4ED8'">Agregar Nueva Categoría</a>
        </div>
    @endif

    <!-- Listado de categorías -->
    <div style="display: grid; grid-template-columns: repeat(1, 1fr); gap: 1.5rem; margin-top: 1.5rem;">
        @foreach ($categories as $category)
            <div style="background-color: white; border-radius: 0.375rem; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); overflow: hidden;">
                <div style="padding: 1rem;">
                    <h2 style="font-size: 1.25rem; font-weight: 600;">{{ $category->name }}</h2>
                    <p style="font-size: 0.875rem; color: #6B7280;">{{ $category->description }}</p>

                    <div style="margin-top: 1rem;">

                        <!-- Mostrar los botones de Editar y Eliminar solo para administradores -->
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('categories.edit', $category->id) }}" style="background-color: #f59e0b; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; margin-left: 10px; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#d97706'" onmouseout="this.style.backgroundColor='#f59e0b'">Editar</a>

                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display: inline-block; margin-left: 10px;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background-color: #dc2626; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; border: none; cursor: pointer;">Eliminar</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
