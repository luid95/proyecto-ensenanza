@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Agregar Nuevo Curso</h1>
        
        <form action="{{ route('courses.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Título del Curso</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea name="description" id="description" class="form-control" required></textarea>
            </div>
            
            <div class="mb-3">
                <label for="category" class="form-label">Categoría</label>
                <select name="category_id" id="category" class="form-select" required>
                    <option value="">Selecciona una categoría</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->id }} - {{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Nuevo campo para edad mínima -->
            <div class="mb-3">
                <label for="min_age" class="form-label">Edad Mínima</label>
                <input type="number" name="min_age" id="min_age" class="form-control" min="5" required>
                <small class="form-text text-muted">La edad mínima debe ser 5 años o más.</small>
            </div>

            <button type="submit" class="btn btn-primary">Crear Curso</button>
        </form>
    </div>
@endsection
