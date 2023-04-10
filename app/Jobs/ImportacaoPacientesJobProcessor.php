<?php

namespace App\Jobs;

use App\Models\Paciente;
use Illuminate\Queue\InteractsWithQueue;

class ImportacaoPacientesJobProcessor
{
    use InteractsWithQueue;


    public function handle($job, $data)
    {
        $csvData = array_map('str_getcsv', file($data['path']));

         // Remove header row
        $csvData = array_shift($csvData);

        try {
        foreach ($csvData as $row) {

            //print_r($row);

            $paciente = new Paciente();
            $paciente->pac_foto = $row[0];
            $paciente->pac_nome = $row[1];
            $paciente->pac_nome_mae = $row[2];
            $paciente->pac_data = $row[3];
            $paciente->pac_cpf = $row[4];
            $paciente->pac_cns = $row[5];
            $paciente->created_at = date('Y-m-d H:i:s');

            // Save paciente to database
            $paciente->save();
        }

        // Delete the file
        unlink($data['path']);

        // Mark the job as completed
        $job->delete();

    } catch (\Exception $e) {
    Log::error('Erro ao inserir dados no banco de dados: '.$e->getMessage());
    // Ou
    dd('Erro ao inserir dados no banco de dados: '.$e->getMessage());
}
}
}
