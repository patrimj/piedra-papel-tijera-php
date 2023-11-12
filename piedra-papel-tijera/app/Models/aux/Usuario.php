<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Partida;
use App\Models\Tirada;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Usuario extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    // BBDD
    protected $table = 'usuarios';

    protected $primaryKey = 'id';
    protected $keyType = 'int'; 
    public $incrementing = true; 
    protected $hidden = ['password', 'remember_token']; // no se mostrará la contraseña en las consultas
    public $timestamps = false;

    // CAMPOS DE LA TABLA
    protected $fillable = [ // campos que se pueden modificar
        'id',
        'nombre',
        'contraseña',
        'partidas_jugadas',
        'partidas_ganadas',
        'rol',
    ];

    // RELACIONES ENTRE TABLAS

    public function partidas()
    {
        return $this->hasMany(Partida::class, 'id_usuario', 'id');
    }

    public function tiradas()
    {
        return $this->hasMany(Tirada::class, 'id_usuario', 'id');
    }

}
