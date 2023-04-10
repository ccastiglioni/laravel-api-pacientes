<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PacienteController;
use App\Jobs\SendJob;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 */

 Route::apiResource('paciente', PacienteController::class);
 Route::get('paciente/cep/{cep}', [PacienteController::class,'getCep']);

 Route::post('pacientes/importar', [PacienteController::class, 'importar']);

 Route::get('/job',function (){
    SendJob::dispatch();
    return view('index');
 });
