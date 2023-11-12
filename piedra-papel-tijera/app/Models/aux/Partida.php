<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Usuario;

class Partida extends Model
{
    use HasFactory;

    // BBDD
    protected $table = 'partidas';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;

    // CAMPOS DE LA TABLA
    protected $fillable = [
        'usuario_id', 
        'finalizada', 
        'resultado'
    ];

    // RELACIONES ENTRE TABLAS

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id');
    }

    public function tiradas()
    {
        return $this->hasMany(Tirada::class, 'id_partida', 'id');
    }

}
