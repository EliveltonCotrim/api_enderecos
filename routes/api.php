<?php

use App\Http\Controllers\Api\EnderecoController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::apiResource('/endereco', EnderecoController::class);
Route::get('buscar-endereco/{cep}', [EnderecoController::class, 'buscarEndereco']);
Route::post('/endereco', [EnderecoController::class, 'store']);
Route::get('/endereco', [EnderecoController::class, 'index']);
Route::delete('/endereco/{id}', [EnderecoController::class, 'destroy']);
Route::get('/endereco/{id}', [EnderecoController::class, 'edit']);
