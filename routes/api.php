<?php
use App\Http\Controllers\API\CourseController as APICourseController;
use App\Http\Controllers\API\VideoController as APIVideoController;
use App\Http\Controllers\API\CommentController as APICommentController;
use Illuminate\Support\Facades\Route;

// Rutas protegidas por autenticación
Route::middleware('auth:sanctum')->group(function () {
    // Listar cursos
    Route::get('courses', [APICourseController::class, 'index']);
    
    // Buscar cursos por categoría, rango de edad, etc.
    Route::get('courses/search', [APICourseController::class, 'search']);
    
    // Registrar un usuario en un curso
    Route::post('courses/{course}/register', [APICourseController::class, 'register']);
    
    // Ver videos de un curso
    Route::get('courses/{course}/videos', [APIVideoController::class, 'index']);
    
    // Comentar en un video
    Route::post('videos/{video}/comment', [APICommentController::class, 'store']);
    
    // Dar like a un video
    Route::post('videos/{video}/like', [APIVideoController::class, 'like']);
});

// Si las rutas no requieren autenticación, se pueden definir aquí
Route::get('courses', [APICourseController::class, 'index']);
Route::get('courses/{course}', [APICourseController::class, 'show']);
