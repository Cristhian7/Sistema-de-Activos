<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modelo;
use App\Models\Marca;

class ModeloController extends Controller
{
    // Muestra la vista con el formulario y la lista de modelos
    public function create()
    {
        $marcas = Marca::all(); // Carga las marcas para el <select>
        $modelos = Modelo::with('marca')->get(); // Carga modelos con su marca asociada

        return view('principal.modelo', compact('marcas', 'modelos'));
    }

    // Guarda el nuevo modelo y redirige a la vista principal
    public function store(Request $request)
    {
        $request->validate([
            'id_marca' => 'required|exists:marca,id_marca',
            'modelo'   => 'required|string|max:100',
        ]);

        Modelo::create([
            'id_marca' => $request->id_marca,
            'modelo'   => $request->modelo,
        ]);

        return redirect()->route('principal')->with('success', 'Modelo creado exitosamente.');
    }
}