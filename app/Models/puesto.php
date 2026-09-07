<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    // Nombre de la tabla en MySQL
    protected $table = 'puesto';

    // Llave primaria
    protected $primaryKey = 'id_puesto';

    // Desactivar timestamps si la tabla no usa created_at/updated_at
    public $timestamps = false;

    // Campos permitidos para inserción masiva
    protected $fillable = [
        'nombre',
    ];
}