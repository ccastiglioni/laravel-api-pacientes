<?php

namespace Database\Seeders;

use App\Models\Endereco;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnderecoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        Endereco::create([
            'end_paciente_id'=>'1',
            'end_cep'=>'9999999',
            'end_endereco'=>'rua borges de medieros',
            'end_numero'=>'134',
            'end_complemento'=>'casa',
            'end_bairro'=>'centro',
            'end_cidade'=>'Santa Maria',
            'end_estado'=>'RS',
        ]);
    }
}
