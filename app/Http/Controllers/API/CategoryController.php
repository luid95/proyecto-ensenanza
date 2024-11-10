<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Obtener todas las categorías con filtro por nombre (si se pasa en la solicitud)
    public function index(Request $request)
    {
        $categories = Category::query();

        // Filtrar por nombre
        if ($request->has('name')) {
            $categories->where('name', 'like', '%' . $request->input('name') . '%');
        }

        $categories = $categories->get();

        return response()->json($categories); // Devolver las categorías en formato JSON
    }

    // Crear una nueva categoría
    public function store(Request $request)
    {
        // Validar los datos
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name'
        ]);

        // Crear la nueva categoría
        $category = Category::create([
            'name' => $validated['name'],
        ]);

        // Devolver una respuesta con el recurso creado
        return response()->json(['message' => 'Categoría creada exitosamente.', 'category' => $category], 201);
    }

    // Obtener una categoría específica por ID
    public function show($id)
    {
        // Buscar la categoría por su ID
        $category = Category::findOrFail($id);

        return response()->json($category); // Devolver la categoría en formato JSON
    }

    // Actualizar una categoría
    public function update(Request $request, $id)
    {
        // Validar los datos
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
        ]);

        // Buscar la categoría por su ID
        $category = Category::findOrFail($id);

        // Actualizar los datos de la categoría
        $category->name = $request->input('name');
        $category->save(); // Guardar los cambios

        return response()->json(['message' => 'Categoría actualizada correctamente.', 'category' => $category]);
    }

    // Eliminar una categoría
    public function destroy($id)
    {
        // Buscar la categoría por su ID
        $category = Category::findOrFail($id);

        // Eliminar la categoría
        $category->delete();

        // Responder con un mensaje de éxito
        return response()->json(['message' => 'Categoría eliminada correctamente.']);
    }
}
