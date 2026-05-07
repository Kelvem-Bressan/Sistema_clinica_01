<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'senha', 'nome', 'raca', 'cor',
        'vacina', 'data_vacina', 'doenca', 'foto',
        'nascimento', 'observacao',
    ];

    protected $hidden = [
        'senha',
    ];

    protected $casts = [
        'nascimento' => 'date',
        'data_vacina' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function consultas()
    {
        return $this->hasMany(Consulta::class);
    }
}
