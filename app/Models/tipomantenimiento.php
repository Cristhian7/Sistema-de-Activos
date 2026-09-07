<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoMantenimiento extends Model
{
    protected $table = 'tipo_mantenimiento';
    protected $primaryKey = 'id_mante'; // Indica la llave primaria
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
    ];
}