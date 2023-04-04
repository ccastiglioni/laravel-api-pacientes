<?php

use App\Http\Controllers\MigrationController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/run_migration', [MigrationController::class,'run']);

Route::get('/run_seeder', [MigrationController::class,'runSeeder']);

Route::get('/run_factory', [MigrationController::class,'runFactory']);
