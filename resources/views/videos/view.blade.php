@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 style="font-size: 1.5rem; font-weight: 600;">{{ $video->title }}</h1>

    <!-- Mostrar el video -->
    <div style="background-color: #f9fafb; padding: 1rem; border-radius: 0.375rem;">
        <iframe width="560" height="315" src="{{ $video->url }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>

    <p style="margin-top: 1rem; color: #6B7280;">Duración del video: {{ $video->minutes }} minutos</p>
</div>
@endsection
