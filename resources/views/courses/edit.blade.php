@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1.25rem;">Editar Curso</h1>

        <!-- Formulario de edición -->
        <form action="{{ route('courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Título del Curso -->
            <div class="mb-4" style="display: flex; flex-direction: column;">
                <label for="title" class="form-label" style="font-size: 0.875rem; font-weight: 500; text-align: justify;">Título del Curso</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $course->title) }}" required style="border: 1px solid #ddd; padding: 0.75rem; border-radius: 0.375rem; width: 100%;">
                <!-- Mostrar mensaje de error debajo del campo de título -->
                @if ($errors->has('title'))
                    <div class="mt-2" style="color: #d9534f; font-size: 1rem; font-weight: 500; text-align: justify;">
                        <small>Título del Curso ya está registrado</small>
                    </div>
                @endif
            </div>

            <!-- Descripción del Curso -->
            <div class="mb-4" style="display: flex; flex-direction: column;">
                <label for="description" class="form-label" style="font-size: 0.875rem; font-weight: 500; text-align: justify;">Descripción</label>
                <textarea name="description" id="description" class="form-control" required style="border: 1px solid #ddd; padding: 0.75rem; border-radius: 0.375rem; width: 100%;">{{ old('description', $course->description) }}</textarea>
            </div>

            <!-- Categoría -->
            <div class="mb-4" style="display: flex; flex-direction: column;">
                <label for="category" class="form-label" style="font-size: 0.875rem; font-weight: 500; text-align: justify;">Categoría</label>
                <select name="category_id" id="category" class="form-select" required style="border: 1px solid #ddd; padding: 0.75rem; border-radius: 0.375rem; width: 100%;">
                    <option value="">Selecciona una categoría</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $course->category_id) == $category->id ? 'selected' : '' }}>{{ $category->id }} - {{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Edad Mínima -->
            <div class="mb-4" style="display: flex; flex-direction: column;">
                <label for="min_age" class="form-label" style="font-size: 0.875rem; font-weight: 500; text-align: justify;">Edad Mínima</label>
                <input type="number" name="min_age" id="min_age" class="form-control" value="{{ old('min_age', $course->min_age) }}" min="5" required style="border: 1px solid #ddd; padding: 0.75rem; border-radius: 0.375rem; width: 100%;">
                <small class="form-text text-muted" style="font-size: 1rem; color: #d9534f; text-align: justify;">La edad mínima debe ser 5 años o más.</small>
            </div>

            <!-- Botón de Enviar -->
            <div class="text-end">
                <button type="submit" class="btn btn-primary" style="background-color: #1E3A8A; color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; transition: background-color 0.3s; width: auto;" onmouseover="this.style.backgroundColor='#2563EB'" onmouseout="this.style.backgroundColor='#1E3A8A'">
                    Actualizar Curso
                </button>
            </div>
        </form>
    </div>
@endsection
