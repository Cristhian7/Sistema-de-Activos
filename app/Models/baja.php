<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Baja extends Model
{
    use HasFactory;

    // Nombre exacto de la tabla en tu base de datos
    protected $table = 'baja';

    // Clave primaria personalizada
    protected $primaryKey = 'id_baja';

    // Desactivar timestamps si la tabla no incluye created_at / updated_at
    public $timestamps = false;

    // Campos permitidos para asignación masiva
    protected $fillable = [
        'id_equipo',
        'tecnico',
        'fecha',
        'años_uso',
        'estado',
        'descripcion',
        'equipo_solicitar',
        'foto',
    ];

    /**
     * Relación con el modelo Equipo (asumiendo que existe el modelo Equipo y su FK es id_equipo)
     */
    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'id_equipo', 'id_equipo');
    }
}