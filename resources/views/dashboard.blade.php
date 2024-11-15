@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1.25rem;">Mis Cursos</h1>

    <!-- Formulario de búsqueda -->
    <form method="GET" action="{{ route('dashboard') }}" style="margin-bottom: 1.5rem;">
        <div style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: flex-end;"> <!-- Alineación en la misma línea -->
            <div style="flex: 1 1 23%; display: flex; flex-direction: column;">
                <label for="category" style="font-size: 0.875rem; font-weight: 500;">Categoría</label>
                <select name="category" id="category" style="border: 1px solid #ddd; padding: 0.5rem; border-radius: 0.375rem; width: 100%;">
                    <option value="">Selecciona categoría</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="flex: 1 1 23%; display: flex; flex-direction: column;">
                <label for="age_range" style="font-size: 0.875rem; font-weight: 500;">Rango de Edad</label>
                <select name="age_range" id="age_range" style="border: 1px solid #ddd; padding: 0.5rem; border-radius: 0.375rem; width: 100%;">
                    <option value="">Selecciona rango de edad</option>
                    <option value="5-8" {{ request('age_range') == '5-8' ? 'selected' : '' }}>5-8 años</option>
                    <option value="9-13" {{ request('age_range') == '9-13' ? 'selected' : '' }}>9-13 años</option>
                    <option value="14-16" {{ request('age_range') == '14-16' ? 'selected' : '' }}>14-16 años</option>
                    <option value="16+" {{ request('age_range') == '16+' ? 'selected' : '' }}>16+ años</option>
                </select>
            </div>

            <div style="flex: 1 1 23%; display: flex; flex-direction: column;">
                <label for="title" style="font-size: 0.875rem; font-weight: 500;">Nombre del Curso</label>
                <input type="text" name="title" id="title" style="border: 1px solid #ddd; padding: 0.5rem; border-radius: 0.375rem; width: 100%;" placeholder="Buscar por nombre" value="{{ request('title') }}">
            </div>

            <!-- Contenedor de los botones de búsqueda y limpiar filtros -->
            <div style="flex: 1 1 auto; display: flex; gap: 1rem;">
                <button type="submit" style="background-color: #1D4ED8; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#1E40AF'" onmouseout="this.style.backgroundColor='#1D4ED8'">Buscar</button>
                
                <!-- Botón Limpiar Filtros con estilo azul -->
                <a href="{{ route('dashboard') }}" style="background-color: #1D4ED8; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; transition: background-color 0.3s; display: inline-block;" onmouseover="this.style.backgroundColor='#1E40AF'" onmouseout="this.style.backgroundColor='#1D4ED8'">Limpiar Filtros</a>
            </div>
        </div>
    </form>

    <!-- Mostrar el botón solo para administradores -->
    @if(auth()->user()->isAdmin())
        <div style="text-align: right; margin-top: 1.5rem;">
            <a href="{{ route('courses.create') }}" style="background-color: #1D4ED8; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#1E40AF'" onmouseout="this.style.backgroundColor='#1D4ED8'">Agregar Nuevo Curso</a>
        </div>
    @endif

    <!-- Listado de cursos -->
    <div style="display: grid; grid-template-columns: repeat(1, 1fr); gap: 1.5rem; margin-top: 1.5rem;">
        @foreach ($courses as $course)
            <div style="background-color: white; border-radius: 0.375rem; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); overflow: hidden;">
                <img src="{{ asset('storage/'.$course->image) }}" alt="{{ $course->title }}" style="width: 100%; height: 12rem; object-fit: cover;">
                <div style="padding: 1rem;">
                    <h2 style="font-size: 1.25rem; font-weight: 600;">{{ $course->title }}</h2>
                    <p style="font-size: 0.875rem; color: #6B7280;">{{ $course->description }}</p>

                    <!-- Mostrar categoría y edad -->
                    <div style="margin-top: 1rem;">
                        <span style="font-size: 0.875rem; color: #6B7280;">Categoría: {{ $course->category->name }}</span><br>
                        <span style="font-size: 0.875rem; color: #6B7280;">Rango de Edad: {{ ucfirst($course->age_group) }}</span>
                    </div>

                    <div style="margin-top: 1rem;">
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('courses.show', $course->id) }}" style="background-color: #1E3A8A; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; display: inline-block; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#2563EB'" onmouseout="this.style.backgroundColor='#1E3A8A'">Ver detalles</a>
                        @elseif( auth()->user()->isUser())
                            <a href="{{ route('courses.show', $course->id) }}" style="background-color: #1E3A8A; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; display: inline-block; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#2563EB'" onmouseout="this.style.backgroundColor='#1E3A8A'">Registrarse al curso</a>
                        @endif

                        <!-- Mostrar los botones de Editar y Eliminar solo para administradores -->
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('courses.edit', $course->id) }}" style="background-color: #f59e0b; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; margin-left: 10px; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#d97706'" onmouseout="this.style.backgroundColor='#f59e0b'">Editar</a>

                            <form action="{{ route('courses.destroy', $course->id) }}" method="POST" style="display: inline-block; margin-left: 10px;">
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
