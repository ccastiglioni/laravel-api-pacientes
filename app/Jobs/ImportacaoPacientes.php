<?
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Jobs\ImportacaoPacientesJobProcessor;

class ImportacaoPacientes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private $path;

    public function __construct($path)
    {

        $this->path = $path;
    }


    public function handle()
    {
        $data = ['path' => $this->path];
        $this->dispatch(new ImportacaoPacientesJobProcessor($data));
    }
}
