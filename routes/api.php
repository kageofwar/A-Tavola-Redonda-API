<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CategoriaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/produtos', [ProdutoController::class, 'index']);
Route::post('/produtos', [ProdutoController::class, 'store']);
Route::get('/produtos/{id}', [ProdutoController::class, 'show']);
Route::put('/produtos/{id}', [ProdutoController::class, 'update']);
Route::delete('/produtos/{id}', [ProdutoController::class, 'destroy']);

Route::get('/fornecedores', [FornecedorController::class, 'index']);
Route::get('/fornecedores/{id}', [FornecedorController::class, 'show']);
Route::post('/fornecedores', [FornecedorController::class, 'store']);
Route::delete('/fornecedores/{id}', [FornecedorController::class, 'destroy']);

Route::get('/categoria', [CategoriaController::class, 'index']);
Route::post('/categoria', [CategoriaController::class, 'store']);
Route::get('/categoria/{id}', [CategoriaController::class, 'show']);
Route::put('/categoria/{id}', [CategoriaController::class, 'update']);
Route::delete('/categoria/{id}', [CategoriaController::class, 'destroy']);

Route::get('/cliente', [ClienteController::class, 'index']);
Route::post('/cliente', [ClienteController::class, 'store']);
Route::get('/cliente/{id}', [ClienteController::class, 'show']);
Route::put('/cliente/{id}', [ClienteController::class, 'update']);
Route::delete('/cliente/{id}', [ClienteController::class, 'destroy']);