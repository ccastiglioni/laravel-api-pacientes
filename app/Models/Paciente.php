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

    public function regras()
    {
         $regras =[
            'nome'=>'required|min:3',
            'imagem'=>'required|file|mimes:png,doc,pdf,jpe',
         ];
         return $regras;
    }

    public function feedbacks(){

         $feedbacks = [
            'nome.unique'=>'Esse campo nome ja existe!',
            'nome.min'=>'Esse campo exige minimo de 3 caracteres!',
            'required'=>'O campo :attribute � obrigart�rio',
         ];

         return $feedbacks;
    }
}
