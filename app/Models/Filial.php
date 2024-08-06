<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filial extends Model
{
    use HasFactory;
    protected $table = 'filiales';
    protected $fillable = ['nombre'];

    public function gerencias()
    {
        return $this->hasMany(Gerencia::class);
    }
}
