<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Baja;
use App\Models\Equipo;

class BajaController extends Controller
{
    public function index()
    {
        $bajas = Baja::all();
        return view('baja.index', compact('bajas')); // Cambia 'baja.index' por la ruta de tu vista de listado
    }

    public function create()
    {
        $equipos = Equipo::all(); // Si necesitas pasar datos a la vista, puedes hacerlo aquí
        return view('principal.baja', compact('equipos')); // Cambia 'baja.create' por la ruta de tu vista del formulario de Nueva Baja
    }

    public function edit($id)
    {
        $equipos = Equipo::all();
        $bajaEditar = Baja::findOrFail($id); // O como nombres tu modelo/variable de baja
        return view('principal.baja', compact('equipos', 'bajaEditar'));
    }


    public function store(Request $request)
    {
        // Validar los datos recibidos del formulario
        $request->validate([
            'id_equipo'        => 'required|integer',
            'estado'           => 'required|string|max:255',
            'fecha'            => 'required|date',
            'tecnico'          => 'required|string|max:255',
            'descripcion'      => 'required|string',
            'años_uso'         => 'required|integer',
            'equipo_solicitar' => 'required|string|max:255',
            'foto'             => 'nullable|image|max:2048', 
        ]);

        // Crear la nueva instancia del modelo
        $baja = new Baja();
        $baja->id_equipo        = $request->id_equipo;
        $baja->estado           = $request->estado;
        $baja->fecha            = $request->fecha;
        $baja->tecnico          = $request->tecnico;
        $baja->descripcion      = $request->descripcion;
        $baja->años_uso         = $request->años_uso;
        $baja->equipo_solicitar = $request->equipo_solicitar;

        // Manejar la subida de la foto si existe
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('bajas', 'public');
            $baja->foto = $path;
        }

        // Guardar en la base de datos
        $baja->save();

        // Redirigir de vuelta al formulario con mensaje de éxito
        return redirect()->back()->with('success', 'Baja registrada con éxito.');
    }
}