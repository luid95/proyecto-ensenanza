<?php

namespace App\Http\Controllers\API;

use App\Models\Course;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    // Obtener todos los cursos con filtros
    public function index(Request $request)
    {
        $query = Course::query();

        // Filtro por categoría
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Filtro por rango de edad
        if ($request->has('age_range') && $request->age_range != '') {
            $ageRange = $request->age_range;

            if ($ageRange == '5-8') {
                $query->where('age_group', '>=', 5)->where('age_group', '<=', 8);
            } elseif ($ageRange == '9-13') {
                $query->where('age_group', '>=', 9)->where('age_group', '<=', 13);
            } elseif ($ageRange == '14-16') {
                $query->where('age_group', '>=', 14)->where('age_group', '<=', 16);
            } elseif ($ageRange == '16+') {
                $query->where('age_group', '>=', 16);
            }
        }

        // Filtro por título
        if ($request->has('title') && $request->title) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        // Obtener los cursos filtrados con la categoría relacionada
        $courses = $query->with('category')->get();

        return response()->json($courses); // Devolver cursos en formato JSON
    }

    // Obtener un curso específico
    public function show(Course $course)
    {
        return response()->json($course); // Devuelve el curso en formato JSON
    }

    // Crear un nuevo curso
    public function store(Request $request)
    {
        // Validar los datos de la solicitud
        $validated = $request->validate([
            'title' => 'required|unique:courses,title|max:255',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'min_age' => 'required|integer|min:5',
        ]);

        // Crear el curso
        $course = Course::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
            'age_group' => $validated['min_age'],
        ]);

        // Retornar la respuesta con el curso creado
        return response()->json(['message' => 'Curso creado exitosamente', 'course' => $course], 201);
    }

    // Actualizar un curso
    public function update(Request $request, $id)
    {
        // Validar los datos
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:courses,title,' . $id,
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'min_age' => 'required|string',
        ]);

        // Obtener el curso por su ID
        $course = Course::findOrFail($id);

        // Actualizar los campos del curso
        $course->title = $validated['title'];
        $course->description = $validated['description'];
        $course->category_id = $validated['category_id'];
        $course->age_group = $validated['min_age'];
        $course->save(); // Guardar los cambios

        return response()->json(['message' => 'Curso actualizado correctamente', 'course' => $course]);
    }

    // Eliminar un curso
    public function destroy($id)
    {
        // Obtener el curso por su ID
        $course = Course::findOrFail($id);

        // Eliminar el curso
        $course->delete();

        // Responder con un mensaje de éxito
        return response()->json(['message' => 'Curso eliminado correctamente']);
    }

    // Buscar cursos
    public function search(Request $request)
    {
        $courses = Course::query();

        // Filtrar por título, rango de edad y categoría
        if ($request->has('query') && $request->query('query')) {
            $courses->where('title', 'like', '%' . $request->query('query') . '%');
        }

        if ($request->has('age_group') && $request->query('age_group')) {
            $courses->where('age_group', $request->query('age_group'));
        }

        if ($request->has('category_id') && $request->query('category_id')) {
            $courses->where('category_id', $request->query('category_id'));
        }

        // Obtener los cursos filtrados
        $courses = $courses->with('category')->get();

        return response()->json($courses); // Retornar los cursos filtrados
    }
}
