<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoMantenimiento;

class TipoMantenimientoController extends Controller
{
    // Mostrar formulario y listado
    public function create()
    {
        $tipos = TipoMantenimiento::all();
        $tipoEditar = null;

        return view('principal.tipo_mantenimiento', compact('tipos', 'tipoEditar'));
    }

    // Guardar nuevo tipo de mantenimiento
    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:100|unique:tipo_mantenimiento,nombre',
            'descripcion' => 'nullable|string|max:255',
        ]);

        TipoMantenimiento::create([
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('tipo_mantenimiento.create')->with('success', 'Tipo de mantenimiento registrado correctamente.');
    }

    // Cargar datos para edición
    public function edit($id)
    {
        $tipos = TipoMantenimiento::all();
        $tipoEditar = TipoMantenimiento::findOrFail($id);

        return view('principal.tipo_mantenimiento', compact('tipos', 'tipoEditar'));
    }

    // Actualizar registro existente
    public function update(Request $request, $id)
    {
        $tipo = TipoMantenimiento::findOrFail($id);

        $request->validate([
            'nombre'      => 'required|string|max:100|unique:tipo_mantenimiento,nombre,' . $id . ',id_mante',
            'descripcion' => 'nullable|string|max:255',
        ]);

        $tipo->update([
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('tipo_mantenimiento.create')->with('success', 'Tipo de mantenimiento actualizado correctamente.');
    }

    // Eliminar registro
    public function destroy($id)
    {
        $tipo = TipoMantenimiento::findOrFail($id);
        $tipo->delete();

        return redirect()->route('tipo_mantenimiento.create')->with('success', 'Tipo de mantenimiento eliminado correctamente.');
    }
}