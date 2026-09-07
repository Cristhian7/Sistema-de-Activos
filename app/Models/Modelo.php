<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    // Nombre de la tabla en MySQL
    protected $table = 'modelo';

    // Llave primaria
    protected $primaryKey = 'id_modelo';

    // Desactivar timestamps
    public $timestamps = false;

    // Campos permitidos para inserción masiva
    protected $fillable = [
        'modelo',
        'id_marca',
    ];

    // Relación con la tabla Marca
    public function marca()
    {
        return $this->belongsTo(Marca::class, 'id_marca', 'id_marca');
    }
}