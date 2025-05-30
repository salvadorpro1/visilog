<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'apellido', 'cedula', 'filial_id', 'gerencia_id', 'razon_visita','nacionalidad','foto','numero_carnet','clasificacion','nombre_empresa','telefono','tipo_carnet'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function filial()
    {
        return $this->belongsTo(Filial::class);
    }

    public function gerencia()
    {
        return $this->belongsTo(Gerencia::class)->withTrashed();
    }
}
