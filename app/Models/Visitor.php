<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'apellido', 'cedula', 'filial', 'gerencia', 'razon_visita'];
}
