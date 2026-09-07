<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuario';

    // 1. Especifica el nombre exacto de la clave primaria en phpMyAdmin
    // Reemplaza 'id_usuario' por la columna que sea tu llave primaria (ej. 'id_usuario', 'idusuario', etc.)
    protected $primaryKey = 'id_usuario'; 

    // 2. Desactiva los campos automatizados created_at y updated_at si tu tabla no los utiliza
    public $timestamps = false;

    protected $fillable = [
        'nombre_usuario',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
