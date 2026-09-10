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
        // Traemos los equipos uniendo modelo y marca a través de id_modelo
        $equipos = DB::table('equipo')
            ->leftJoin('modelo', 'equipo.id_modelo', '=', 'modelo.id_modelo')
            ->leftJoin('marca', 'modelo.id_marca', '=', 'marca.id_marca')
            ->select('equipo.*', 'modelo.modelo as nombre_modelo', 'marca.marca as nombre_marca')
            ->get();

        $equipoEditar = null;

        if ($request->has('editar')) {
            $equipoEditar = Equipo::find($request->editar);
        }

        // Tablas auxiliares para llenar los combobox / selects
        $afiliados  = DB::table('afiliado')->get();
        $categorias = DB::table('categoria')->get();
        $empleados  = DB::table('empleados')->get();
        $estados    = DB::table('estado')->get();

        // Cargar modelos junto a su marca correspondiente para el select
        $modelos = DB::table('modelo')
            ->leftJoin('marca', 'modelo.id_marca', '=', 'marca.id_marca')
            ->select('modelo.id_modelo', 'modelo.modelo', 'marca.marca')
            ->orderBy('marca.marca', 'asc')
            ->get();

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
        $validated = $request->validate([
            'nombre_equipo' => 'required|string|max:150',
            'tipo_equipo'   => 'required|string|max:100',
            'cod_contable'  => 'nullable|string|max:50',
            'cod_ti'        => 'nullable|string|max:50',
            'tag'           => 'nullable|string|max:100',
            'ip'            => 'nullable|string|max:50',
            'cpu'           => 'nullable|string|max:100',
            'ram'           => 'nullable|string|max:50',
            'disco'         => 'nullable|string|max:100',
            'usuario'       => 'nullable|string|max:100',
            'password'      => 'nullable|string|max:100',
            'ec'            => 'nullable|string|max:100',
            'referencia'    => 'nullable|string|max:150',
            'valor'         => 'nullable|numeric',
            'fecha_compra'  => 'nullable|date',
            'id_afiliado'   => 'nullable',
            'id_categoria'  => 'nullable',
            'id_empleado'   => 'nullable',
            'id_estado'     => 'nullable',
            'id_modelo'     => 'required|exists:modelo,id_modelo', // El modelo define la marca
            'descripcion'   => 'nullable|string',
        ]);

        // Asignación de la imagen LONGBLOB si se sube un archivo
        if ($request->hasFile('imagen')) {
            $validated['imagen'] = file_get_contents($request->file('imagen')->getRealPath());
        }

        Equipo::create($validated);

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
            'tipo_equipo'   => 'required|string|max:100',
            'cod_contable'  => 'nullable|string|max:50',
            'cod_ti'        => 'nullable|string|max:50',
            'tag'           => 'nullable|string|max:100',
            'ip'            => 'nullable|string|max:50',
            'cpu'           => 'nullable|string|max:100',
            'ram'           => 'nullable|string|max:50',
            'disco'         => 'nullable|string|max:100',
            'usuario'       => 'nullable|string|max:100',
            'password'      => 'nullable|string|max:100',
            'ec'            => 'nullable|string|max:100',
            'referencia'    => 'nullable|string|max:150',
            'valor'         => 'nullable|numeric',
            'fecha_compra'  => 'nullable|date',
            'id_afiliado'   => 'nullable',
            'id_categoria'  => 'nullable',
            'id_empleado'   => 'nullable',
            'id_estado'     => 'nullable',
            'id_modelo'     => 'required|exists:modelo,id_modelo',
            'descripcion'   => 'nullable|string',
            'imagen'        => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['_token', '_method', 'imagen', 'id_marca']);

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