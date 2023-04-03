<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Endereco;
use Illuminate\Database\Seeder;
use App\Models\Paciente;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

       // $this->call([PacienteSeeder::class]); // para add um Seeder
        Paciente::factory()->count(20)->create();
        Endereco::factory()->count(50)->create();
    }
}
