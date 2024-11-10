<?php

namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query();

        // Filtrar por nombre
        if ($request->has('name')) {
            $categories->where('name', 'like', '%' . $request->input('name') . '%');
        }

        $categories = $categories->get();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

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

        // Redirigir a la página de categorías con un mensaje de éxito
        return redirect()->route('categories.index')->with('success', 'Categoría creada exitosamente.');
    }

    public function edit($id)
    {
        // Obtener el curso por su ID
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        // Validar los datos de la solicitud
        $request->validate([
            'name' => 'required|unique:categories,name,' . $id,
        ]);

        // Buscar la categoría por su ID
        $category = Category::findOrFail($id);

        // Actualizar el nombre de la categoría
        $category->name = $request->input('name');
        $category->save(); // Guardar los cambios

        // Redirigir al listado de categorías con un mensaje de éxito
        return redirect()->route('categories.index')->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy($id)
    {
        // Buscar la categoría por su ID
        $category = Category::findOrFail($id);

        // Eliminar la categoría
        $category->delete();

        // Redirigir al listado de categorías con un mensaje de éxito
        return redirect()->route('categories.index')->with('success', 'Categoría eliminada correctamente.');
    }

}
