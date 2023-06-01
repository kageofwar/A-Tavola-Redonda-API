<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PedidoItensController;

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

Route::post('/cadastrar', [AuthController::class, 'cadastrar']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function() {

    Route::get('/produtos', [ProdutoController::class, 'index']);
    Route::post('/produtos', [ProdutoController::class, 'store']);
    Route::get('/produtos/{id}', [ProdutoController::class, 'show']);
    Route::put('/produtos/{id}', [ProdutoController::class, 'update']);
    Route::delete('/produtos/{id}', [ProdutoController::class, 'destroy']);
    
    Route::get('/fornecedores', [FornecedorController::class, 'index']);
    Route::get('/fornecedores/{id}', [FornecedorController::class, 'show']);
    Route::post('/fornecedores', [FornecedorController::class, 'store']);
    Route::delete('/fornecedores/{id}', [FornecedorController::class, 'destroy']);
    Route::put('/fornecedores/{id}', [FornecedorController::class, 'update']);
    
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
    
    Route::get('/pedidos', [PedidoController::class, 'index']);
    Route::post('/pedidos', [PedidoController::class, 'store']);
    Route::get('/pedidos/por_pagamento', [PedidoController::class, "por_pagamento"]);
    Route::get('/pedidos/por_status', [PedidoController::class, "por_status"]);
    Route::get('/pedidos/por_categoria', [PedidoController::class, "por_categoria"]);
    Route::get('/pedidos/{id}', [PedidoController::class, 'show']);
    Route::put('/pedidos/{id}', [PedidoController::class, 'update']);
    Route::delete('/pedidos/{id}', [PedidoController::class, 'destroy']);
    
    Route::get('/itens/{id}', [PedidoItensController::class, 'ListarItensdoPedido']);    
    Route::post('/itens', [PedidoItensController::class, 'store']);


    Route::post('/logout', [AuthController::class, 'logout']);
});

