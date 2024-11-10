{{-- resources/views/profile.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Perfil de {{ Auth::user()->name }}</h1>
    <p>Email: {{ Auth::user()->email }}</p>
    <p>Rol: {{ Auth::user()->role }}</p>
    
    <a href="{{ route('logout') }}" class="btn btn-danger">Cerrar sesión</a>
</div>
@endsection
