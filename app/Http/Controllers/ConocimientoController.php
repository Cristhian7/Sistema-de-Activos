<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ConocimientoController extends Controller
{
    public function index()
    {
        $mantenimientos = DB::table('mantenimiento')
            ->leftJoin('equipo', 'mantenimiento.id_equipo', '=', 'equipo.id_equipo')
            ->leftJoin('tipo_mantenimiento', 'mantenimiento.id_tipo_mante', '=', 'tipo_mantenimiento.id_mante')
            ->select(
                'mantenimiento.id_mante',
                'equipo.cod_contable',
                'equipo.nombre_equipo',
                'tipo_mantenimiento.nombre as tipo_mante',
                'mantenimiento.fecha_inicio',
                'mantenimiento.fecha_final',
                'mantenimiento.tecnico',
                'mantenimiento.no_ticket',
                'mantenimiento.descripcion'
            )
            ->orderBy('mantenimiento.fecha_final', 'desc')
            ->get();

        return view('principal.conocimiento', compact('mantenimientos'));
    }

    public function generarPdf($id)
    {
        $mantenimiento = DB::table('mantenimiento')
            ->leftJoin('equipo', 'mantenimiento.id_equipo', '=', 'equipo.id_equipo')
            ->leftJoin('modelo', 'equipo.id_modelo', '=', 'modelo.id_modelo')
            ->leftJoin('marca', 'modelo.id_marca', '=', 'marca.id_marca')
            ->leftJoin('afiliado', 'equipo.id_afiliado', '=', 'afiliado.id_afiliado')
            ->leftJoin('tipo_mantenimiento', 'mantenimiento.id_tipo_mante', '=', 'tipo_mantenimiento.id_mante')
            ->leftJoin('estado', 'equipo.id_estado', '=', 'estado.id_estado') // Relacionado con equipo
            ->select(
                'mantenimiento.*',
                'equipo.cod_contable',
                'equipo.nombre_equipo',
                'equipo.tag as serie',
                'marca.marca as marca',
                'modelo.modelo as modelo',
                'afiliado.nombre as ubicacion',
                'tipo_mantenimiento.nombre as tipo_mante',
                'estado.nombre as estado_nombre'
            )
            ->where('mantenimiento.id_mante', $id)
            ->first();

        if (!$mantenimiento) {
            return redirect()->back()->with('error', 'Registro de mantenimiento no encontrado.');
        }

        $fotoAntesBase64 = $mantenimiento->foto_antes ? 'data:image/jpeg;base64,' . base64_encode($mantenimiento->foto_antes) : null;
        $fotoDespuesBase64 = $mantenimiento->foto_despues ? 'data:image/jpeg;base64,' . base64_encode($mantenimiento->foto_despues) : null;

        $pdf = Pdf::loadView('principal.ConocimientoPDF', compact('mantenimiento', 'fotoAntesBase64', 'fotoDespuesBase64'));
        
        return $pdf->stream('Reporte_Mantenimiento_' . ($mantenimiento->no_ticket ?? $mantenimiento->id_mante) . '.pdf');
    }
}