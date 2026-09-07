<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EquipoController extends Controller
{
    // Mostrar lista y formulario para crear/editar
    public function index(Request $request)
    {
        $equipos = Equipo::all();
        $equipoEditar = null;

        if ($request->has('editar')) {
            $equipoEditar = Equipo::find($request->editar);
        }

        // Tablas auxiliares para llenar los combobox / selects
        // Ajusta las tablas según tus nombres reales en la BD
        $afiliados  = DB::table('afiliado')->get();
        $categorias = DB::table('categoria')->get();
        $empleados  = DB::table('empleados')->get();
        $estados    = DB::table('estado')->get();
        $modelos    = DB::table('modelo')->get();

        return view('principal.equipo', compact(
            'equipos',
            'equipoEditar',
            'afiliados',
            'categorias',
            'empleados',
            'estados',
            'modelos'
        ));
        
    }

    // Guardar nuevo registro
    public function store(Request $request)
    {
        $request->validate([
            'nombre_equipo' => 'required|string|max:150',
            'tipo_equipo'   => 'required|string|max:100',
            'cod_contable'  => 'nullable|string|max:50',
            'cod_ti'        => 'nullable|string|max:50',
            'imagen'        => 'nullable|image|max:2048', // Máximo 2MB
            'valor'         => 'nullable|numeric|max:999999.99',
            'fecha_compra'  => 'nullable|date',
        ]);

        $data = $request->except(['_token', 'imagen']);

        // Tratamiento de la imagen para campo LONGBLOB
        if ($request->hasFile('imagen')) {
            $data['imagen'] = file_get_contents($request->file('imagen')->getRealPath());
        }

        Equipo::create($data);

        return redirect()->route('equipo.index')->with('success', 'Equipo registrado con éxito.');
    }

    // Cargar datos para editar
    public function edit($id)
    {
        return redirect()->route('equipo.index', ['editar' => $id]);
    }

    // Actualizar registro existente
    public function update(Request $request, $id)
    {
        $equipo = Equipo::findOrFail($id);

        $request->validate([
            'nombre_equipo' => 'required|string|max:150',
            'cod_contable'  => 'nullable|string|max:50',
            'cod_ti'        => 'nullable|string|max:50',
            'imagen'        => 'nullable|image|max:2048',
            'valor'         => 'nullable|numeric',
            'fecha_compra'  => 'nullable|date',
        ]);

        $data = $request->except(['_token', '_method', 'imagen']);

        // Si se sube una nueva imagen, reemplaza el BLOB
        if ($request->hasFile('imagen')) {
            $data['imagen'] = file_get_contents($request->file('imagen')->getRealPath());
        }

        $equipo->update($data);

        return redirect()->route('equipo.index')->with('success', 'Equipo actualizado con éxito.');
    }

    // Eliminar registro
    public function destroy($id)
    {
        $equipo = Equipo::findOrFail($id);
        $equipo->delete();

        return redirect()->route('equipo.index')->with('success', 'Equipo eliminado correctamente.');
    }

    // Ruta para renderizar la imagen LONGBLOB en la etiqueta <img src="...">
    public function mostrarImagen($id)
    {
        $equipo = Equipo::findOrFail($id);

        if (!$equipo->imagen) {
            return abort(404);
        }

        return response($equipo->imagen)->header('Content-Type', 'image/jpeg');
    }
}