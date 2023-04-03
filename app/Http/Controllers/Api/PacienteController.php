<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Endereco;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client;



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

        }else{
            $paciente = $this->paciente->get();
            //dd( $marca);
        }

        return response()->json($paciente,200);
    }


    public function store(Request $request)
    {
        $name_img = rand(0,1000).'padrao.jpg';

        if ($imagem = $request->file('pac_foto')) {
            $name_img =$imagem->store('imagens/paciente','public');
        }

        $dadosbd = [
            'pac_nome'   => $request->get('pac_nome'),
            'pac_nome_mae'=> $request->get('pac_nome_mae'),
            'pac_data'   => $request->get('pac_data'),
            'pac_cpf'    => $request->get('pac_cpf'),
            'pac_cns'    => $request->get('pac_cns'),
            'pac_foto'   => $name_img
        ];

        $paciente  = $this->paciente->create($dadosbd);
        $pacienteId = $paciente->id;

        $enderecos = $request->get('enderecos');
        foreach($enderecos as $enderecoData) {

            $enderecoData['end_paciente_id'] = $pacienteId;
            $endereco = new Endereco([
                'end_cep' => $enderecoData['end_cep'],
                'end_endereco' => $enderecoData['end_endereco'],
                'end_numero' => $enderecoData['end_numero'],
                'end_complemento' => $enderecoData['end_complemento'],
                'end_bairro' => $enderecoData['end_bairro'],
                'end_cidade' => $enderecoData['end_cidade'],
            ]);
            $paciente->enderecos()->save($endereco);
        }

        $return = response()->json( $paciente , 201);

        return $return;
    }


    public function show($id)
    {
        // Valida o ID do paciente
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:pacientes,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $paciente = Paciente::findOrFail($id);
    //TESTAR com RELACIONAMENTO : $paciente = Paciente::with('enderecos')->findOrFail($id);
        return response()->json($paciente,200);
    }



    public function update(Request $request, $id)
    {
        $modelo = $this->paciente->find($id);

        if($modelo === null) {
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso solicitado não existe'], 404);
        }

        if($request->method() === 'PATCH') {

            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no Model
           /*  foreach($modelo->rules() as $input => $regra) {

                if(array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            } */

            //$request->validate($regrasDinamicas);

        } else {
            $request->validate($modelo->rules());
        }

        //remove o arquivo antigo caso um novo arquivo tenha sido enviado no request
        if($request->file('imagem')) {
            Storage::disk('public')->delete($modelo->imagem);
        }

        $imagem = $request->file('imagem');
       // $imagem_urn = $imagem->store('imagens/modelos', 'public');

        $modelo->fill($request->all());
        $modelo->save();

        return response()->json($modelo, 200);
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
            Cache::put($cep, $arrCep, 30);
        }

        return $arrCep;
    }

}
