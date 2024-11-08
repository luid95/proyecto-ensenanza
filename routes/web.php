<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\CommentController;
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

// Rutas para el Administrador (requieren rol de administrador y estar autenticado)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('courses', CourseController::class);
    Route::resource('videos', VideoController::class);
    Route::resource('comments', CommentController::class);
    
    // Otras rutas exclusivas para el administrador
});

// Rutas para el Usuario (requieren estar autenticados y con rol de usuario)
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('courses', [CourseController::class, 'index']);
    Route::get('courses/{course}', [CourseController::class, 'show']);
    Route::post('courses/{course}/register', [CourseController::class, 'register']);
    Route::get('courses/{course}/videos', [VideoController::class, 'index']);
    Route::post('videos/{video}/comment', [CommentController::class, 'store']);
    Route::post('videos/{video}/like', [VideoController::class, 'like']);
});

// Ruta de inicio (redirige a la vista 'home' si está autenticado)
Route::get('/home', function () {
    return view('home');
})->name('home');
