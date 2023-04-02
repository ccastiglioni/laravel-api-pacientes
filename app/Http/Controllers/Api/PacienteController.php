<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


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
                 //$paciente = $paciente->where($c[0], $c[1], $c[2]);
                // $result = $this->paciente->where($c[0], $c[1], $c[2]);
                //$paciente = $this->paciente->where('pac_nome_mae','like' ,'H%' );
                //dd($paciente->get());
                $result = $this->paciente->where($c[0], $c[1], $c[2])->get();
                $paciente = $paciente->merge($result);

                // Concatena os resultados na variável $paciente
               // $paciente = $paciente->concat($result);
            }

        }else{
            $paciente = $this->paciente->get();
            //dd( $marca);
        }


        return response()->json($paciente,200);
    }


    public function store(Request $request)
    {

        // $marca  = Paciente::create($request->all()); // Da pra fazer esse insert em massa MAS colocando o $fillable na Model

        $name_img ='padrao.jpg';

        //$request->validate($this->paciente->regras(), $this->paciente->feedbacks() );

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
        $return = response()->json( $paciente , 201);

        return $return; // Obs: o Laravel ja retorna um json_encode()
    }


    public function show($id)
    {
        // Valida o ID do paciente
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:pacientes,id',
        ]);

        // Verifica se há erros de validação
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Busca o paciente e retorna em formato JSON
        $paciente = Paciente::findOrFail($id);
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

                //coletar apenas as regras aplicáveis aos parâmetros parciais da requisição PATCH
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
       // $modelo->imagem = $imagem_urn;
        $modelo->save();

        return response()->json($modelo, 200);
    }


    public function destroy($id)
    {
        // Valida o ID do paciente
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:pacientes,id',
        ]);

        // Verifica se há erros de validação
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Exclui o paciente
        $paciente = Paciente::findOrFail($id);
        $paciente->delete();
        return response()->json(['message' => "Paciente ID: {$id} removido com sucesso."]);
    }

}
