<?php

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Web\CourseController;
use App\Http\Controllers\Web\VideoController;
use App\Http\Controllers\Web\CommentController;
use App\Http\Controllers\AuthController;

use Illuminate\Support\Facades\Route;

// Ruta predeterminada (si no está autenticado, lo redirige al login)
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas de inicio de sesión
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Ruta de registro de usuario
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);

// Rutas autenticadas (requiere que el usuario esté autenticado)
Route::middleware(['auth'])->group(function () {
    // Rutas para gestionar cursos, videos y comentarios
    Route::resource('courses', CourseController::class);
    Route::resource('videos', VideoController::class);
    Route::resource('comments', CommentController::class);
});

// Ruta de inicio (redirige a la vista 'home' si está autenticado)
Route::get('/dashboard', [CourseController::class, 'index'])->name('dashboard')->middleware('auth');
// Ruta para ver o editar el perfil del usuario
Route::middleware('auth')->get('/profile', [ProfileController::class, 'show'])->name('profile');
