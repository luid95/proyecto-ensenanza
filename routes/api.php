<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryApiController;
use App\Http\Controllers\API\CourseApiController;
use App\Http\Controllers\API\VideoApiController;
use App\Http\Controllers\API\CommentApiController;
use App\Http\Controllers\API\CourseUserApiController;

use Illuminate\Support\Facades\Route;

// Rutas de inicio de sesión (para autenticación)
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

// Rutas autenticadas (requiere que el usuario esté autenticado)
Route::middleware(['auth:sanctum'])->group(function () {
    // Rutas para gestionar categorías, cursos, videos y comentarios
    Route::resource('categories', CategoryApiController::class);
    Route::resource('courses', CourseApiController::class);
    Route::resource('videos', VideoApiController::class);
    Route::resource('comments', CommentApiController::class);
    
    // Ruta para ver el progreso del curso (un curso específico)
    Route::get('courses/{course_id}/progress', [CourseUserApiController::class, 'show']);
    
    // Ruta para gestionar el progreso de los cursos
    Route::resource('courses/progress', CourseUserApiController::class);
    
    // Ruta para ver o editar el perfil del usuario
    Route::get('/profile', [AuthController::class, 'profile']);
});

// Ruta predeterminada si no se está autenticado (redirige al login)
Route::middleware('auth:sanctum')->get('/dashboard', [CourseApiController::class, 'index'])->name('dashboard');
