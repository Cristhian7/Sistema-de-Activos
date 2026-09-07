<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marca;

class MarcaController extends Controller
{
    // Mostrar la vista con el formulario y la lista existente de marcas
    public function create()
    {
        $marcas = Marca::all(); // Obtiene todas las marcas registradas
        return view('principal.marca', compact('marcas'));
    }

    // Guardar la nueva marca y redirigir al menú principal con alerta
    public function store(Request $request)
    {
        $request->validate([
            'marca' => 'required|string|max:100|unique:marca,marca',
        ]);

        Marca::create([
            'marca' => $request->marca,
        ]);

        // Redirige al menú principal con la notificación
        return redirect()->route('principal')->with('success', 'Marca creada exitosamente.');
    }
}