<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    // Nombre exacto de la tabla en MySQL
    protected $table = 'marca';

    // Llave primaria
    protected $primaryKey = 'id_marca';

    // Desactivar timestamps si tu tabla no tiene created_at / updated_at
    public $timestamps = false;

    // Campos permitidos para inserción
    protected $fillable = [
        'id_marca',
        'marca',
    ];
}