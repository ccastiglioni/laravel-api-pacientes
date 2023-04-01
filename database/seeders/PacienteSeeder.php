<?php

namespace Database\Seeders;

use App\Models\Paciente;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PacienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Paciente::create([
            'pac_foto'=> 'paciente.png',
            'pac_nome'=> 'Sandro da silva',
            'pac_nome_mae'=> 'Horizete silva',
            'pac_data'=> '1991-11-11',
            'pac_cpf'=>9933478593,
            'pac_cns'=>444444
        ]);
    }
}
