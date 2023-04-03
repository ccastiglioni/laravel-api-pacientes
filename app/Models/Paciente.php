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
            'pac_nome'=>'required|min:4',
            'pac_cpf'=>'required|unique:pacientes',
            'pac_foto'=>'required|min:8',
         ];
         return $regras;
    }

    public function feedbacks(){

         $feedbacks = [
            'pac_cpf.unique'=>'CPF já existe, cadastre outro por favor!',
            'pac_nome.unique'=>'Esse Nome de paciente já existe!',
            'pac_nome.min'=>'O campo Nome exige minimo de 3 caracteres!',
            'required'=>'O campo :attribute é obrigartorio',
         ];

         return $feedbacks;
    }

    public function enderecos()
    {
                        //< Relacionamento > , <Chave Estrangeira> , <Chave Primaria>
        return $this->hasMany(Endereco::class,'end_paciente_id'    ,'id');
    }
}
