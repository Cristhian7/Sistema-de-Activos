<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BajaEquipoController extends Controller
{
    public function index(Request $request)
    {
        $bajas = DB::table('baja')
            ->leftJoin('equipo', 'baja.id_equipo', '=', 'equipo.id_equipo')
            ->leftJoin('modelo', 'equipo.id_modelo', '=', 'modelo.id_modelo')
            ->leftJoin('marca', 'modelo.id_marca', '=', 'marca.id_marca')
            ->select(
                'baja.*',
                'equipo.nombre_equipo',
                'equipo.cod_ti',
                'equipo.cod_contable',
                'equipo.tag',
                'equipo.ec',
                'equipo.cpu',
                'equipo.ram',
                'equipo.disco',
                'marca.marca as nombre_marca',
                'modelo.modelo as nombre_modelo'
            )
            ->orderBy('baja.id_baja', 'desc')
            ->get();

        // Lista de equipos incluyendo fecha_compra para el cálculo automático
        $equipos = DB::table('equipo')
            ->select('id_equipo', 'nombre_equipo', 'cod_ti', 'cod_contable', 'tag', 'ec', 'cpu', 'ram', 'disco', 'fecha_compra')
            ->orderBy('cod_contable', 'asc')
            ->get();
        
        // Lista de técnicos
        $tecnicos = DB::table('users')
            ->select('id as id_tecnico', 'name as nombre')
            ->get();

        // Editar baja
        $bajaEditar = null;
        if ($request->has('editar')) {
            $bajaEditar = DB::table('baja')
                ->where('id_baja', $request->get('editar'))
                ->first();
        }

        return view('principal.BajaEquipo', compact(
            'bajas', 
            'equipos', 
            'tecnicos', 
            'bajaEditar'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tecnico'          => 'required|string',
            'id_equipo'        => 'required',
            'equipo_solicitar' => 'required|string',
        ]);

        $data = [
            'id_equipo'        => $request->id_equipo,
            'tecnico'          => $request->tecnico,
            'estado'           => $request->estado,
            'fecha'            => $request->fecha,
            'años_uso'         => $request->años_uso,
            'descripcion'      => $request->descripcion,
            'equipo_solicitar' => $request->equipo_solicitar,
        ];

        if ($request->hasFile('foto')) {
            $data['foto'] = file_get_contents($request->file('foto')->getRealPath());
        }

        DB::table('baja')->insert($data);

        return redirect()->route('baja.index')->with('success', 'Baja registrada correctamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tecnico'          => 'required|string',
            'id_equipo'        => 'required',
            'equipo_solicitar' => 'required|string',
        ]);

        $data = [
            'id_equipo'        => $request->id_equipo,
            'tecnico'          => $request->tecnico,
            'estado'           => $request->estado,
            'fecha'            => $request->fecha,
            'años_uso'         => $request->años_uso,
            'descripcion'      => $request->descripcion,
            'equipo_solicitar' => $request->equipo_solicitar,
        ];

        if ($request->hasFile('foto')) {
            $data['foto'] = file_get_contents($request->file('foto')->getRealPath());
        }

        DB::table('baja')->where('id_baja', $id)->update($data);

        return redirect()->route('baja.index')->with('success', 'Baja actualizada correctamente.');
    }

    public function destroy($id)
    {
        DB::table('baja')->where('id_baja', $id)->delete();
        return redirect()->route('baja.index')->with('success', 'Baja eliminada correctamente.');
    }

    public function listado()
    {
        $bajas = DB::table('baja')
            ->leftJoin('equipo', 'baja.id_equipo', '=', 'equipo.id_equipo')
            ->select('baja.*', 'equipo.nombre_equipo', 'equipo.cod_contable')
            ->get();

        return view('principal.ListaBajas', compact('bajas'));
    }

public function generarPdf($id)
{
    $baja = DB::table('baja')
        ->leftJoin('equipo', 'baja.id_equipo', '=', 'equipo.id_equipo')
        ->leftJoin('modelo', 'equipo.id_modelo', '=', 'modelo.id_modelo')
        ->leftJoin('marca', 'modelo.id_marca', '=', 'marca.id_marca')
        ->leftJoin('afiliado', 'equipo.id_afiliado', '=', 'afiliado.id_afiliado')
        ->select(
            'baja.*',
            'equipo.nombre_equipo',
            'equipo.cod_ti',
            'equipo.cod_contable',
            'equipo.tag',
            'equipo.ec',
            'equipo.cpu',
            'equipo.ram',
            'equipo.disco',
            'afiliado.nombre as afiliado',
            'marca.marca as nombre_marca',
            'modelo.modelo as nombre_modelo'
        )
        ->where('baja.id_baja', $id)
        ->first();

    if (!$baja) {
        return redirect()->back()->with('error', 'Registro no encontrado.');
    }

    // --- EXTRACCIÓN DINÁMICA Y DETECCIÓN DE TIPO MIME ---
    $rawFoto = DB::table('baja')->where('id_baja', $id)->value('foto');
    
    if (is_resource($rawFoto)) {
        $rawFoto = stream_get_contents($rawFoto);
    }

    $fotoBase64 = null;
    if (!empty($rawFoto) && strlen($rawFoto) > 50) {
        // Detectar si es jpeg, png, etc. automáticamente
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->buffer($rawFoto);
        
        // Si por alguna razón no detecta el mime, por defecto usamos image/jpeg
        if (!$mimeType || !str_starts_with($mimeType, 'image/')) {
            $mimeType = 'image/jpeg';
        }
        
        $fotoBase64 = 'data:' . $mimeType . ';base64,' . base64_encode($rawFoto);
    }
    
    $baja->foto_base64 = $fotoBase64;
    // ----------------------------------------------------

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('principal.BajasEquipoPDF', compact('baja'));
    return $pdf->stream('baja-equipo-' . $id . '.pdf');
}
}