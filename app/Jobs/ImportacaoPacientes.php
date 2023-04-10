<?
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
//use App\Jobs\ImportacaoPacientesJobProcessor;
use App\Models\Paciente;
use Illuminate\Support\Facades\Storage;

class ImportacaoPacientes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private $path;

    public function __construct($path)
    {
        $this->path = $path;
    }


 /*    public function handle()
    {
        $data = $this->path;
        //$this->dispatch(new ImportacaoPacientesJobProcessor($data));
        $csvData = array_map('str_getcsv', file($data));

        // Remove header row
       $csvData = array_shift($csvData);

        try {
        foreach ($csvData as $row) {

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
        unlink($path);

        $job->delete();

        } catch (\Exception $e) {
            Log::error('Erro ao inserir dados no banco de dados: '.$e->getMessage());
            // Ou
            dd('Erro ao inserir dados no banco de dados: '.$e->getMessage());
        }
    } */

    public function handle()
    {

        //$file = fopen($this->path, 'r');
        $file = fopen(Storage::path($this->path), 'r');

        $header = fgetcsv($file);


        while (($line = fgetcsv($file)) !== false) {
            // Crie um novo modelo de Paciente com base nos dados do CSV
            $paciente = new Paciente([
                'pac_foto' => $line[0],
                'pac_nome' => $line[1],
                'pac_nome_mae' => $line[2],
                'pac_data' => $line[3],
                'pac_cpf' => $line[4],
                'pac_cns' => $line[5],
            ]);

            // Salve o modelo de Paciente no banco de dados
            $paciente->save();
        }

        fclose($file);
    }
}
