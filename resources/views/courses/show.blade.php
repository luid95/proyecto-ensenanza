@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 style="font-size: 1.5rem; font-weight: 600;">{{ $course->title }}</h1>
    <p style="font-size: 1rem; color: #6B7280;">{{ $course->description }}</p>
    
    <!-- Mostrar categoría, rango de edad y total de minutos -->
    <div style="margin-top: 1rem;">
        <span style="font-size: 0.875rem; color: #6B7280;">Categoría: {{ $course->category->name }}</span><br>
        <span style="font-size: 0.875rem; color: #6B7280;">Rango de Edad: {{ ucfirst($course->age_group) }}</span><br>
        <span style="font-size: 0.875rem; color: #6B7280;">Duración Total: {{ $totalMinutes }} minutos</span>
    </div>

    @if(auth()->user()->isAdmin())
        <div style="margin-top: 1rem;">
            <a href="{{ route('videos.create', ['course' => $course->id]) }}" 
            style="background-color: #1D4ED8; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem;">
            Agregar Video
            </a>
        </div>
    @endif


    <!-- Listado de videos relacionados en dos columnas -->
    <div style="margin-top: 2rem;">
        <h2 style="font-size: 1.25rem; font-weight: 600;">Videos del curso</h2>
        @if($course->videos->isEmpty())
            <p style="color: #6B7280;">Este curso no tiene videos aún.</p>
        @else
            <div class="grid grid-cols-2 md:grid-cols-2 gap-4">
                @foreach($course->videos as $video)
                    @php
                        // Extraer el video_id de la URL
                        preg_match("/(?:https?:\/\/(?:www\.)?youtube\.com\/(?:[^\/\n\s]+\/\S+|(?:v|e(?:mbed)?)\/(\w+)|(?:.*[?&]v=)))([\w\-]+)/", $video->url, $matches);
                        $videoId = $matches[1] ?? '';
                        $thumbnailUrl = $videoId ? "https://img.youtube.com/vi/$videoId/maxresdefault.jpg" : '';
                    @endphp
                    <div style="background-color: #f9fafb; padding: 1rem; border-radius: 0.375rem;">
                        <h3 style="font-size: 1rem; font-weight: 600;">{{ $video->title }}</h3>
                        @if($thumbnailUrl)
                            <img src="{{ $thumbnailUrl }}" alt="Miniatura del video" style="width: 100%; height: auto; border-radius: 0.375rem;">
                        @else
                            <p style="color: #6B7280;">Miniatura no disponible</p>
                        @endif
                        <p>Duracion del video: {{ $video->minutes }} minutos</p>

                        <!-- Botón para el usuario que quiere comenzar a ver el video -->
                        @if(auth()->user()->role == 'user')
                            <a href="{{ route('videos.view', ['video' => $video->id]) }}" 
                               style="background-color: #34D399; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; display: inline-block; margin-top: 1rem;">
                                Ver Video
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
