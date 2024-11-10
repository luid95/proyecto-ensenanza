<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        // Obtener los cursos con filtros
        $query = Course::query();

        // Filtro por categoría
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Filtro por rango de edad
        if ($request->has('age_range') && $request->age_range != '') {
            // Obtener el rango de edad
            $ageRange = $request->age_range;
            
            if ($ageRange == '5-8') {
                // Si el rango es 5-8, filtrar por edad mayor o igual a 5
                $query->where('age_group', '>=', 5)->where('age_group', '<=', 8);
            } elseif ($ageRange == '9-13') {
                // Si el rango es 9-13, filtrar por edad entre 9 y 13
                $query->where('age_group', '>=', 9)->where('age_group', '<=', 13);
            } elseif ($ageRange == '14-16') {
                // Si el rango es 14-16, filtrar por edad entre 14 y 16
                $query->where('age_group', '>=', 14)->where('age_group', '<=', 16);
            } elseif ($ageRange == '16+') {
                // Si el rango es 16+, filtrar por edad mayor o igual a 16
                $query->where('age_group', '>=', 16);
            }
        }

        // Filtro por nombre
        if ($request->has('title') && $request->title) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        // Obtener los cursos filtrados
        $courses = $query->with('category')->get();

        // Obtener todas las categorías para el filtro
        $categories = Category::all();

        // Devolver la vista con los cursos y categorías
        return view('dashboard', compact('courses', 'categories'));
    }

    public function show(Course $course)
    {
        // Obtener los videos relacionados al curso
        $videos = $course->videos;
        return view('courses.show', compact('course', 'videos'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('courses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        
        // Lógica para guardar el nuevo curso
        if (auth()->user()->isAdmin()) {
            $course = new Course();
            $course->title = $request->input('title');
            $course->description = $request->input('description');
            $course->category_id = $request->input('category_id');
            $course->age_group = $request->input('min_age');
            $course->save();

            return redirect()->route('courses.index');
        }
    }
}
