<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    protected $table = 'equipo';
    protected $primaryKey = 'id_equipo';

    // DESACTIVAR TIMESTAMPS (created_at y updated_at)
    public $timestamps = false; 

    protected $fillable = [
        'nombre_equipo',
        'tipo_equipo',
        'cod_contable',
        'cod_ti',
        'tag',
        'ip',
        'cpu',
        'ram',
        'disco',
        'usuario',
        'password',
        'ec',
        'referencia',
        'valor',
        'fecha_compra',
        'id_afiliado',
        'id_categoria',
        'id_empleado',
        'id_estado',
        'id_modelo', // Se conserva id_modelo (id_marca se omitió)
        'descripcion',
        'imagen'
    ];

    // Relaciones para consultas Eloquent
    public function modelo()
    {
        return $this->belongsTo(Modelo::class, 'id_modelo', 'id_modelo');
    }

    public function afiliado()
    {
        return $this->belongsTo(Afiliado::class, 'id_afiliado', 'id_afiliado');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado', 'id_estado');
    }
}