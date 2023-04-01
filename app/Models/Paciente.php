<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $fillable = [
        'pac_foto',
        'pac_nome',
        'pac_nome_mae',
        'pac_data',
        'pac_cpf',
        'pac_cns',
    ];

}
