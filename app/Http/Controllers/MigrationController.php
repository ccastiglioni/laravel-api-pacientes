<?php

namespace App\Http\Controllers;

use Database\Factories\EnderecoFactory;
use Database\Factories\PacienteFactory;

use Database\Seeders\EnderecoSeeder;
use Database\Seeders\PacienteSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class MigrationController extends Controller
{
    public function run()
    {
        Artisan::call('migrate');
        $resposta = "Migracao concluida com Sucesso!";

        return response()->json($resposta);
    }


    public function runSeeder()
    {
        $seeder = new PacienteSeeder();
        $seeder->run();
        $response= 'Seeder paciente concluido!';

        $seeder = new EnderecoSeeder();
        $seeder->run();
        $response.= ' E  Seeder enderecos concluido!';

        return response()->json($response);
    }

    public function runFactory()
    {
        $factory = new PacienteFactory(User::class);
        $factory->times(25)->create();
        $response = 'Factory paciente concluido ..';

        $factory = new EnderecoFactory(User::class);
        $factory->times(50)->create();
        $response.= 'E Factory de Endereco concluido!';
        return response()->json($response);
    }
}
