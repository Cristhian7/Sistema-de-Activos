<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'categoria';

    // Llave primaria
    protected $primaryKey = 'id_categoria';

    // Desactivar timestamps si la tabla no usa created_at/updated_at
    public $timestamps = false;

    // Campos permitidos para inserción masiva
    protected $fillable = [
        'categoria',
    ];
}

