<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    protected $fillable = [
        'end_paciente_id',
        'end_cep',
        'end_endereco',
        'end_numero',
        'end_complemento',
        'end_bairro',
        'end_cidade',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

}
