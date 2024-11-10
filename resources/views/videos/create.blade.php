@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1.25rem;">Agregar Nuevo Video</h1>

    <form action="{{ route('videos.store') }}" method="POST">
        @csrf
        <input type="hidden" name="course_id" value="{{ $course_id }}">

        <div class="mb-4" style="display: flex; flex-direction: column;">
            <label for="title" class="form-label" style="font-size: 0.875rem; font-weight: 500; text-align: justify;">Título del Video</label>
            <input type="text" name="title" id="title" class="form-control" required style="border: 1px solid #ddd; padding: 0.75rem; border-radius: 0.375rem; width: 100%;">
        </div>

        <div class="mb-4" style="display: flex; flex-direction: column;">
            <label for="url" class="form-label" style="font-size: 0.875rem; font-weight: 500; text-align: justify;">URL del Video (YouTube)</label>
            <input type="url" name="url" id="url" class="form-control" required style="border: 1px solid #ddd; padding: 0.75rem; border-radius: 0.375rem; width: 100%;">
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary" style="background-color: #1E3A8A; color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; transition: background-color 0.3s; width: auto;" onmouseover="this.style.backgroundColor='#2563EB'" onmouseout="this.style.backgroundColor='#1E3A8A'">
                Guardar Video
            </button>
        </div>
    </form>
</div>
@endsection
