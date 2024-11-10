<?php

namespace App\Http\Controllers\API;

use App\Models\Course;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        return response()->json(Course::with('category')->get());  // Devuelve la lista de cursos
    }

    public function show(Course $course)
    {
        return response()->json($course);  // Devuelve un curso específico
    }

    public function search(Request $request)
    {
        $courses = Course::where('title', 'like', '%' . $request->query('query') . '%')
                          ->orWhere('age_group', $request->query('age_group'))
                          ->orWhere('category_id', $request->query('category_id'))
                          ->get();
        return response()->json($courses);
    }

    public function register(Course $course)
    {
        // Lógica para registrar un usuario en un curso
    }
}
