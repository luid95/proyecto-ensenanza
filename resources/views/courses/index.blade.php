{{-- resources/views/courses/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1>Cursos Disponibles</h1>
    <ul>
        @foreach ($courses as $course)
            <li>
                <a href="{{ route('courses.show', $course->id) }}">{{ $course->title }}</a> - 
                {{ $course->category->name }} (Edad: {{ $course->age_group }})
            </li>
        @endforeach
    </ul>
@endsection
