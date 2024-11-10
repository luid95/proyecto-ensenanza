<?php

namespace App\Http\Controllers\API;

use App\Models\Course;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseUserController extends Controller
{
    public function index(Request $request)
    {
        // Obtener todos los cursos con los usuarios y su progreso, solo si el usuario está autenticado
        $courses = Course::with(['users' => function ($query) {
            $query->select('id', 'name'); // Seleccionar solo algunos campos del usuario
        }])->get();

        // Responder con la información en formato JSON
        return response()->json($courses);
    }

    public function show($course_id, Request $request)
    {
        // Obtener un curso específico con sus usuarios y su progreso
        $course = Course::with(['users' => function ($query) {
            $query->select('id', 'name'); // Seleccionar solo algunos campos del usuario
        }])->findOrFail($course_id);

        // Responder con la información del curso en formato JSON
        return response()->json($course);
    }
}
