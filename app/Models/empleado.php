<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleados';
    protected $primaryKey = 'id_empleado';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'id_afiliado',
        'id_puesto',
        'cod_l4',
        'dpi',
    ];

    // Relación con Afiliado
    public function afiliado()
    {
        return $this->belongsTo(Afiliado::class, 'id_afiliado', 'id_afiliado');
    }

    // Relación con Puesto
    public function puesto()
    {
        return $this->belongsTo(Puesto::class, 'id_puesto', 'id_puesto');
    }
}
