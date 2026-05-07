<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinica_id', 'pet_id', 'user_id', 'data', 'hora', 'motivo', 'status',
    ];

    protected $casts = [
        'data' => 'date',
    ];

    public function clinica()
    {
        return $this->belongsTo(Clinica::class);
    }

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
