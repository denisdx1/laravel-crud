<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    use HasFactory;

    protected $table = 'historiales'; // Si difiere del singular/plural de Eloquent

    protected $fillable = [
        'dni',
        'descripcion',
    ];

    // Relación inversa: un historial pertenece a un paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'dni', 'dni');
    }
}
