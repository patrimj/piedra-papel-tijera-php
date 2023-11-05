<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tirada extends Model
{
    protected $table = 'tiradas';
    protected $fillable = [
        'partida_id', 
        'jugador1_id', 
        'tirada_jugador1', 
        'tirada_jugador2', 
        'resultado'
    ];
}
