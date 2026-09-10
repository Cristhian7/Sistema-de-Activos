<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    public function index()
    {
        $equipos = DB::table('equipo')
            // Hacemos el join de modelo primero
            ->leftJoin('modelo', 'equipo.id_modelo', '=', 'modelo.id_modelo')
            // Relacionamos la marca desde la tabla modelo (modelo.id_marca = marca.id_marca)
            ->leftJoin('marca', 'modelo.id_marca', '=', 'marca.id_marca')
            ->leftJoin('afiliado', 'equipo.id_afiliado', '=', 'afiliado.id_afiliado')
            ->select(
                'equipo.cod_ti',
                'equipo.cod_contable',
                'equipo.nombre_equipo',
                'equipo.tipo_equipo',
                'marca.marca as marca',
                'modelo.modelo as modelo',
                'equipo.usuario',
                'afiliado.nombre as afiliado'
            )
            ->get();

        return view('principal.index', compact('equipos'));
    }
}