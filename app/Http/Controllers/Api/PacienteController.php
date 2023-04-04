<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\ImportacaoPacientes;
use App\Models\Endereco;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

class PacienteController extends Controller
{

    public function __construct(Paciente $paciente){
        // Usando Metodo Injecao do Model
        $this->paciente = $paciente;
     }

    public function index(Request $request)
    {

        if($request->has('filtro')) {

            $filtros = $request->get('filtro');
            $filtros = explode(';', $filtros);

            $paciente = collect();

            foreach($filtros as $key => $condicao) {
                $c = explode(':', $condicao);
                //print_r($c);
                $result = $this->paciente->where($c[0], $c[1], $c[2])->get();
                $paciente = $paciente->merge($result);
            }

        }elseif ($request->has('nome')) {
            $paciente = $this->paciente->where('pac_nome', 'like', '%'.$request->get('nome').'%')->get();

        }elseif ($request->has('cpf')) {
            $paciente = $this->paciente->where('pac_cpf', $request->get('cpf'))->get();

        }else{
            $paciente = $this->paciente->get();
        }

        return response()->json($paciente,200);
    }


    public function store(Request $request)
    {
        try {
            $name_img = rand(0,1000).'padrao.jpg';

            $request->validate($this->paciente->regras(), $this->paciente->feedbacks());

            $dadosbd = [
                'pac_nome'   => $request->get('pac_nome'),
                'pac_nome_mae'=> $request->get('pac_nome_mae'),
                'pac_data'   => $request->get('pac_data'),
                'pac_cpf'    => $request->get('pac_cpf'),
                'pac_cns'    => $request->get('pac_cns'),
                'pac_foto'   => $name_img
            ];

            $paciente = $this->paciente->create($dadosbd);

            $enderecos = $request->get('endereco');

            $paciente->enderecos()->create($enderecos);

            $return = response()->json($paciente, 201);

            return $return;
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['erro' => $e->getMessage()], 422);
        }
    }


    public function show($id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:pacientes,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $paciente = Paciente::with('enderecos')->findOrFail($id);
        return response()->json($paciente,200);
    }



    public function update(Request $request, $id)
    {

        try {
            $paciente = $this->paciente->find($id);

            if($paciente === null) {
                return response()->json(['erro' => 'Impossível realizar a atualização. O recurso solicitado não existe'], 404);
            }

            if($request->method() === 'PATCH') {

                $regrasDinamicas = array();

                //percorrendo todas as regras definidas no Model
                 foreach($paciente->regras() as $input => $regra) {

                    if(array_key_exists($input, $request->all())) {
                        $regrasDinamicas[$input] = $regra;
                    }
                }

                $request->validate($regrasDinamicas, $paciente->feedbacks());

            } else {
                $request->validate($paciente->regras(), $paciente->feedbacks());
            }

            $paciente->fill($request->all());
            $paciente->save();

            return response()->json($paciente, 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['erro' => $e->getMessage()], 422);
        }
    }


    public function destroy($id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:pacientes,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $paciente = Paciente::findOrFail($id);
        $paciente->delete();
        return response()->json(['message' => "Paciente ID: {$id} removido com sucesso."]);
    }

    public function getCep($cep)
    {
        $arrCep =[];

        if (Cache::has($cep)){
            $arrCep = Cache::get($cep);
            $arrCep['Cache'] = true;
        }else{
            $client = new Client();
            $response = $client->get("https://viacep.com.br/ws/{$cep}/json/");
            $endereco = json_decode($response->getBody());
            $arrCep = [
                'rua' => $endereco->logradouro,
                'bairro' => $endereco->bairro,
                'cidade' => $endereco->localidade,
                'estado' => $endereco->uf,
                'cep' => $endereco->cep,
                'Cache'=>false
            ];
            Cache::put($cep, $arrCep, 15);
        }

        return $arrCep;
    }



    public function importar(Request $request)
    {
        //dd($request);
        $validated = $request->validate([
            'arquivo' => 'required|mimes:csv,txt',
        ]);

        $file = $validated['arquivo'];

        $path = Storage::putFile('csv', $file);

        if (!$path) {
            throw ValidationException::withMessages([
                'arquivo' => 'Could not upload file.',
            ]);
        }
            //print_r($path);

        ImportacaoPacientes::dispatch($path);

        return response()->json(['message' => 'Importing data from CSV file.']);
    }

}
