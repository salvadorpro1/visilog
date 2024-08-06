<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filial extends Model
{
    use HasFactory;
<<<<<<< HEAD

    protected $table = 'filiales';  // especificar el nombre de la tabla si es necesario

=======
    protected $table = 'filiales';
>>>>>>> recuperacion-commit
    protected $fillable = ['nombre'];

    public function gerencias()
    {
        return $this->hasMany(Gerencia::class);
    }
}
