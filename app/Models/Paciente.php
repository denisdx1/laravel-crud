<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $table = 'pacientes';
    protected $primaryKey = 'dni';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'dni',
        'nombre',
        'apellido',
        'estado'
    ];

    // Relación con Historial: un paciente tiene muchos historiales
    public function historiales()
    {
        return $this->hasMany(Historial::class, 'dni', 'dni');
    }
}
