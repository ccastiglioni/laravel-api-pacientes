<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    public function index(Request $request)
    {
        $numeros_por_pg=3;

        if($request->has('filtro')) {
            $filtros = $request->get('filtro');

            $filtros = explode(';', $filtros);
            //dd($filtros);

            foreach($filtros as $key => $condicao) {

                $c = explode(':', $condicao);
                $marca = $this->marca->where($c[0], $c[1], $c[2]);
                //a query está sendo montada
            }
        }else{

            //$marca = $this->marca->with('marca_modelos');
            $marca = Paciente::all();
            //dd( $marca);
        }

      /*   if($request->has('atributos_modelos')) {
            $atributos_modelos = 'modelos:id,'.$request->atributos_modelos;
            $marcaRepository->selectAtributosRegistrosRelacionados($atributos_modelos);
        }else{
            $marca = $this->marca->with('marca_modelos')->paginate($numeros_por_pg);
        } */
        //$marca = $this->marca->with('marca_modelos')->get();

        return response()->json($marca);
    }


    public function store(Request $request)
    {
        $store =  ['store'=>  $request];

        return response()->json($store);
    }


    public function show(Paciente $paciente)
    {
        $store =  ['show'=>  $paciente];

        return response()->json($store);
    }


    public function update(Request $request, Paciente $paciente)
    {
        $update =  ['update'=>  $paciente, 'request'=>$request];

        return response()->json($update);
    }


    public function destroy(Paciente $paciente)
    {
        $destroy =  ['destroy'=>  $paciente, 'request'=>$request];

        return response()->json($destroy);
    }
}
