<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';

    protected $fillable = [
        'id',
        'nombre',
        'contraseña',
        'partidas_jugadas',
        'partidas_ganadas',
        'rol',
    ];

}
