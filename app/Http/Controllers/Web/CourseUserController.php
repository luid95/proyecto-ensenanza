<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseUserController extends Controller
{
    public function index()
    {
        // Obtener todos los cursos con los usuarios registrados y su progreso
        $courses = Course::with('users')->get();

        // Retornar la vista con los cursos y los usuarios
        return view('course_user.index', compact('courses'));
    }
}
