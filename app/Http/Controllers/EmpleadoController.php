<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Afiliado;
use App\Models\Puesto;

class EmpleadoController extends Controller
{
    // Mostrar formulario y listado
    public function create()
    {
        $afiliados = Afiliado::all();
        $puestos = Puesto::all();
        $empleados = Empleado::with(['afiliado', 'puesto'])->get();
        $empleadoEditar = null; // Variable para identificar si se está editando

        return view('principal.empleado', compact('afiliados', 'puestos', 'empleados', 'empleadoEditar'));
    }

    // Guardar nuevo empleado
    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:150',
            'id_afiliado' => 'required|exists:afiliado,id_afiliado',
            'id_puesto'   => 'required|exists:puesto,id_puesto',
            'cod_l4'      => 'nullable|string|max:50',
            'dpi'         => 'required|string|max:20|unique:empleados,dpi',
        ]);

        Empleado::create([
            'nombre'      => $request->nombre,
            'id_afiliado' => $request->id_afiliado,
            'id_puesto'   => $request->id_puesto,
            'cod_l4'      => $request->cod_l4,
            'dpi'         => $request->dpi,
        ]);

        return redirect()->route('empleados.create')->with('success', 'Empleado guardado exitosamente.');
    }

    // Cargar datos en el formulario para editar
    public function edit($id)
    {
        $afiliados = Afiliado::all();
        $puestos = Puesto::all();
        $empleados = Empleado::with(['afiliado', 'puesto'])->get();
        $empleadoEditar = Empleado::findOrFail($id);

        return view('principal.empleado', compact('afiliados', 'puestos', 'empleados', 'empleadoEditar'));
    }

    // Actualizar registro existente
    public function update(Request $request, $id)
    {
        $empleado = Empleado::findOrFail($id);

        $request->validate([
            'nombre'      => 'required|string|max:150',
            'id_afiliado' => 'required|exists:afiliado,id_afiliado',
            'id_puesto'   => 'required|exists:puesto,id_puesto',
            'cod_l4'      => 'nullable|string|max:50',
            'dpi'         => 'required|string|max:20|unique:empleados,dpi,' . $id . ',id_empleado',
        ]);

        $empleado->update([
            'nombre'      => $request->nombre,
            'id_afiliado' => $request->id_afiliado,
            'id_puesto'   => $request->id_puesto,
            'cod_l4'      => $request->cod_l4,
            'dpi'         => $request->dpi,
        ]);

        return redirect()->route('empleados.create')->with('success', 'Empleado actualizado exitosamente.');
    }

    // Eliminar registro
    public function destroy($id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->delete();

        return redirect()->route('empleados.create')->with('success', 'Empleado eliminado exitosamente.');
    }
}