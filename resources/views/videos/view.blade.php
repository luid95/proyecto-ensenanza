@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- Columna principal para el video -->
        <div class="col-md-8 col-12">
            <h1 style="font-size: 1.5rem; font-weight: 600;">{{ $video->title }}</h1>

            <!-- Mostrar el video -->
            <div style="background-color: #f9fafb; padding: 1rem; border-radius: 0.375rem;">
                <iframe width="560" height="315" 
                src="{{ str_replace('watch?v=', 'embed/', $video->url) }}" 
                frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                allowfullscreen id="videoFrame"></iframe>
            </div>

            <p style="margin-top: 1rem; color: #6B7280;">Duración del video: {{ $video->minutes }} minutos</p>
            <p style="margin-top: 0.5rem; color: #6B7280;">Progreso del curso: {{ round($progressPercentage, 2) }}%</p>

            <!-- Botón para marcar el video como visto -->
            <button id="markAsWatchedBtn" class="btn btn-primary" onclick="markAsWatched()">Marcar como visto</button>
        </div>

        <!-- Columna secundaria para listar los videos -->
        <div class="col-md-4 col-12">
            <h2 style="font-size: 1.25rem; font-weight: 600;">Videos relacionados</h2>
            <ul class="list-group">
                @foreach($course->videos as $relatedVideo)
                    <li class="list-group-item 
                        @if(in_array($relatedVideo->id, $watchedVideos)) 
                            bg-green-200 border-4 border-green-500 
                        @endif">
                        <a href="{{ route('videos.view', $relatedVideo->id) }}" style="text-decoration: none; color: inherit;">
                            {{ $relatedVideo->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<script>
    function markAsWatched() {
        fetch(`/mark-video-as-watched/{{ $video->id }}/{{ $course->id }}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())  // Cambia a .json() para procesar la respuesta como JSON
        .then(data => {
            console.log(data);
            if (data.message) {
                alert(data.message); // Mostrar el mensaje que viene del servidor
            } else {
                alert("¡Progreso actualizado!");
            }
        })
        .catch(error => {
            console.error('Error al registrar progreso:', error);
            alert('Hubo un problema al actualizar el progreso.');
        });
    }
</script>

@endsection
