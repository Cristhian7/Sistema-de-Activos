<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MantenimientoController extends Controller
{
    public function index(Request $request)
    {
       $mantenimientos = DB::table('mantenimiento')
    ->leftJoin('equipo', 'mantenimiento.id_equipo', '=', 'equipo.id_equipo')
    ->leftJoin('tipo_mantenimiento', 'mantenimiento.id_tipo_mante', '=', 'tipo_mantenimiento.id_mante')
    ->leftJoin('modelo', 'equipo.id_modelo', '=', 'modelo.id_modelo')
    ->leftJoin('marca', 'modelo.id_marca', '=', 'marca.id_marca')
    ->select(
        'mantenimiento.*',
        'equipo.nombre_equipo',
        'equipo.cod_ti',
        'equipo.cod_contable',
        'equipo.tag',
        'equipo.ec',
        'equipo.cpu',
        'equipo.ram',
        'equipo.disco',
        'tipo_mantenimiento.nombre as nombre_tipo_mante',
        'marca.marca as nombre_marca',
        'modelo.modelo as nombre_modelo'
    )
    ->orderBy('mantenimiento.id_mante', 'desc')
    ->get();

        // Lista de equipos para el select
        $equipos = DB::table('equipo')
            ->select('id_equipo', 'nombre_equipo', 'cod_ti', 'cod_contable', 'tag', 'ec', 'cpu', 'ram', 'disco')
            ->orderBy('cod_contable', 'asc')
            ->get();

        // Lista de tipos de mantenimiento
        $tiposMantenimiento = DB::table('tipo_mantenimiento')
            ->select('id_mante as id_tipo_mante', 'nombre')
            ->get();
        
        // Lista de técnicos
        $tecnicos = DB::table('users')
            ->select('id as id_tecnico', 'name as nombre')
            ->get();

        // Editar mantenimiento
        $mantenimientoEditar = null;
        if ($request->has('editar')) {
            $mantenimientoEditar = DB::table('mantenimiento')
                ->where('id_mante', $request->get('editar'))
                ->first();
        }

        return view('principal.mantenimiento', compact(
            'mantenimientos', 
            'equipos', 
            'tiposMantenimiento', 
            'tecnicos', 
            'mantenimientoEditar'
        ));
    }

    public function store(Request $request)
{
    $request->validate([
        'tecnico'   => 'required|string',
        'id_equipo' => 'required',
    ]);

    // Obtener id_empleado del equipo seleccionado si no se pasa en el request
    $idEmpleado = $request->id_empleado;

    if (!$idEmpleado && $request->id_equipo) {
        $equipo = DB::table('equipo')->where('id_equipo', $request->id_equipo)->first();
        $idEmpleado = $equipo->id_empleado ?? 1; // Coloca un ID por defecto (ej. 1) si no tiene asignado
    }

    $data = [
        'fecha_inicio'  => $request->fecha_inicio ?? $request->fecha_inicial,
        'fecha_final'   => $request->fecha_final,
        'descripcion'   => $request->descripcion,
        'id_tipo_mante' => $request->id_tipo_mante,
        'tecnico'       => $request->tecnico,
        'no_ticket'     => $request->no_ticket,
        'id_equipo'     => $request->id_equipo,
        'id_empleado'   => $idEmpleado,
    ];

    if ($request->hasFile('foto_antes')) {
        $data['foto_antes'] = file_get_contents($request->file('foto_antes')->getRealPath());
    }

    if ($request->hasFile('foto_despues')) {
        $data['foto_despues'] = file_get_contents($request->file('foto_despues')->getRealPath());
    }

    DB::table('mantenimiento')->insert($data);

    return redirect()->route('mantenimiento.index')->with('success', 'Mantenimiento registrado correctamente.');
}

    

   
    public function update(Request $request, $id)
    {
        $request->validate([
            'tecnico'   => 'required|string',
            'id_equipo' => 'required',
        ]);

        $data = [
            'fecha_inicio'  => $request->fecha_inicio ?? $request->fecha_inicial,
            'fecha_final'   => $request->fecha_final,
            'descripcion'   => $request->descripcion,
            'id_tipo_mante' => $request->id_tipo_mante,
            'tecnico'       => $request->tecnico,
            'no_ticket'     => $request->no_ticket,
            'id_equipo'     => $request->id_equipo,
            'id_empleado'   => $request->id_empleado ?? null,
        ];

        if ($request->hasFile('foto_antes')) {
            $data['foto_antes'] = file_get_contents($request->file('foto_antes')->getRealPath());
        }

        if ($request->hasFile('foto_despues')) {
            $data['foto_despues'] = file_get_contents($request->file('foto_despues')->getRealPath());
        }

        DB::table('mantenimiento')->where('id_mante', $id)->update($data);

        return redirect()->route('mantenimiento.index')->with('success', 'Mantenimiento actualizado correctamente.');
    }

    public function destroy($id)
    {
        DB::table('mantenimiento')->where('id_mante', $id)->delete();
        return redirect()->route('mantenimiento.index')->with('success', 'Mantenimiento eliminado correctamente.');
    }
}