<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Afiliado;

class AfiliadoController extends Controller
{
    // Muestra la vista con el formulario y la lista de afiliados existentes
    public function create()
    {
        $afiliados = Afiliado::all();
        return view('principal.afiliado', compact('afiliados'));
    }

    // Guarda el nuevo afiliado y redirige al menú principal con mensaje de éxito
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:150|unique:afiliado,nombre',
        ]);

        Afiliado::create([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('principal')->with('success', 'Afiliado creado exitosamente.');
    }
}