<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gerencia extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nombre', 'filial_id'];

    public function filial()
    {
        return $this->belongsTo(Filial::class);
    }
}
