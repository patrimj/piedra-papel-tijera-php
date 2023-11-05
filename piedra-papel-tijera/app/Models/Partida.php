<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    protected $table = 'partidas';
    protected $fillable = [
        'usuario_id', 
        'finalizada', 
        'resultado'
    ];
}
