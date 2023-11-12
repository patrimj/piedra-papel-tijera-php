<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Partida;


class Tirada extends Model
{
    use HasFactory;

    // BBDD
    protected $table = 'tiradas';

    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;

    // CAMPOS DE LA TABLA
    protected $fillable = [
        'partida_id', 
        'jugador1_id', 
        'tirada_jugador1', 
        'tirada_jugador2', 
        'resultado'
    ];

    // RELACIONES ENTRE TABLAS

    public function partida()
    {
        return $this->belongsTo(Partida::class, 'id_partida', 'id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id');
    }

}
