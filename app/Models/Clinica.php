<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Clinica extends Authenticatable
{
    use HasFactory;

    protected $table = 'clinicas';

    protected $fillable = [
        'cnpj', 'nome', 'cidade', 'uf', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function consultas()
    {
        return $this->hasMany(Consulta::class);
    }
}
