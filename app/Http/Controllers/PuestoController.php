<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Puesto;

class PuestoController extends Controller
{
    // Muestra la vista con el formulario y la lista de puestos existentes
    public function create()
    {
        $puestos = Puesto::all();
        return view('principal.puesto', compact('puestos'));
    }

    // Guarda el nuevo puesto y redirige al menú principal con mensaje de éxito
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:150|unique:puesto,nombre',
        ]);

        Puesto::create([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('principal')->with('success', 'Puesto creado exitosamente.');
    }
}