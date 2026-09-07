<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    protected $table = 'equipo';
    
    // Si tu llave primaria no es 'id', cámbiala aquí (ej. 'id_equipo')
    protected $primaryKey = 'id_equipo'; 
    public $timestamps = false;

    protected $fillable = [
        'cod_contable',
        'cod_ti',
        'cpu',
        'descripcion',
        'disco',
        'ec',
        'fecha_compra',
        'id_afiliado',
        'id_categoria',
        'id_empleado',
        'id_estado',
        'id_modelo',
        'imagen',
        'ip',
        'nombre_equipo',
        'password',
        'ram',
        'referencia',
        'tag',
        'tipo_equipo',
        'usuario',
        'valor',
    ];
}