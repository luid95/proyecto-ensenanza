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
        // Validar que el título del curso no esté duplicado
        $validated = $request->validate([
            'title' => 'required|unique:courses,title|max:255',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'min_age' => 'required|integer|min:5',
        ]);

        // Crear el curso si la validación pasa
        $course = new Course();
        $course->title = $request->title;
        $course->description = $request->description;
        $course->category_id = $request->category_id;
        $course->age_group = $request->min_age;
        $course->save();

        return redirect()->route('courses.index')->with('success', 'Curso creado exitosamente.');
    }

    public function edit($id)
    {
        // Obtener el curso por su ID
        $course = Course::findOrFail($id);

        // Obtener todas las categorías para el selector
        $categories = Category::all();

        // Pasar el curso y las categorías a la vista
        return view('courses.edit', compact('course', 'categories'));
    }

    public function update(Request $request, $id)
    {
        // Validación de los datos del formulario
        $request->validate([
            'title' => 'required|string|max:255|unique:courses,title,' . $id,
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'min_age' => 'required|string',
        ]);

        // Obtener el curso por su ID
        $course = Course::findOrFail($id);

        // Actualizar los campos del curso
        $course->title = $request->input('title');
        $course->description = $request->input('description');
        $course->category_id = $request->input('category_id');
        $course->age_group = $request->input('min_age');

        // Guardar los cambios en la base de datos
        $course->save();

        // Redirigir a la vista de detalle del curso con un mensaje de éxito
        return redirect()->route('courses.index', $course->id)
            ->with('success', 'Curso actualizado correctamente');
    }

    public function destroy($id)
    {
        // Buscar el curso por su ID
        $course = Course::findOrFail($id);

        // Eliminar el curso
        $course->delete();

        // Redirigir de vuelta al listado de cursos con un mensaje de éxito
        return redirect()->route('dashboard')->with('success', 'Curso eliminado correctamente');
    }
}
