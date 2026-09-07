<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    // Muestra la vista con el formulario y la lista de categorías existentes
    public function create()
    {
        $categorias = Categoria::all();
        return view('principal.categoria', compact('categorias'));
    }

    // Guarda la nueva categoría y redirige al menú principal con mensaje de éxito
    public function store(Request $request)
    {
        $request->validate([
            'categoria' => 'required|string|max:100|unique:categoria,categoria',
        ]);

        Categoria::create([
            'categoria' => $request->categoria,
        ]);

        return redirect()->route('principal')->with('success', 'Categoría creada exitosamente.');
    }
}