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

            @if(auth()->user()->isUser())
                <!-- Botón para marcar el video como visto -->
                <button id="markAsWatchedBtn" class="btn btn-primary" onclick="markAsWatched()">Marcar como visto</button>
            @endif

            <!-- Sección de Like -->
            @if(auth()->user()->isUser())
                <button id="likeBtn" class="btn btn-primary mt-2" onclick="toggleLike()">
                    {{ auth()->user()->likedVideos->contains($video->id) ? 'Quitar Like' : 'Dar Like' }}
                </button>
            @endif

            <p class="mt-3">Total de likes: {{ $video->likes->count() }}</p>

            <!-- Mostrar comentarios aprobados o desaprobados -->
            <h3 style="margin-top: 2rem; font-size: 1.25rem; font-weight: 600;">Comentarios</h3>
            <ul class="list-group">
                @foreach($video->comments as $comment)
                    @if($comment->approved || auth()->user()->isAdmin())
                        <li class="list-group-item">
                            <strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}
                            
                            @if(auth()->user()->isAdmin())
                                <!-- Switch para aprobar o desaprobar el comentario -->
                                <div class="form-check form-switch float-end ms-2">
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        id="approvalSwitch{{ $comment->id }}" 
                                        onchange="toggleApproval({{ $comment->id }})"
                                        {{ $comment->approved ? 'checked' : '' }}>
                                    <label class="form-check-label" for="approvalSwitch{{ $comment->id }}">Mostrar</label>
                                </div>
                            @endif
                        </li>
                    @endif
                @endforeach
            </ul>

            @if(auth()->user()->isUser())
                <!-- Formulario para dejar un comentario, después del botón -->
                <h3 style="margin-top: 2rem; font-size: 1.25rem; font-weight: 600;">Deja tu comentario</h3>
                <form action="{{ route('comments.store', $video->id) }}" method="POST">
                    @csrf
                    <textarea name="content" rows="4" class="form-control" placeholder="Escribe tu comentario aquí..." required></textarea>
                    <button type="submit" class="btn btn-primary mt-2">Enviar comentario</button>
                </form>
            @endif
            
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
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                alert(data.message);
            } else {
                alert("¡Progreso actualizado!");
            }
        })
        .catch(error => {
            console.error('Error al registrar progreso:', error);
            alert('Hubo un problema al actualizar el progreso.');
        });
    }

    function toggleLike() {
        fetch(`/videos/{{ $video->id }}/toggle-like`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            // Opcional: refrescar la página o actualizar el botón de like
            location.reload(); // Actualiza la página para reflejar el cambio de estado del like
        })
        .catch(error => console.error('Error al dar/quitarlike:', error));
    }

    function toggleApproval(commentId) {
        fetch(`/comments/${commentId}/toggle-approval`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
        })
        .catch(error => console.error('Error al actualizar el estado de aprobación:', error));
    }
</script>
@endsection
