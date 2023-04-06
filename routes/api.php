<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\FornecedorController;

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
Route::delete('/produtos/{id}', [ProdutoController::class, 'destroy']);

Route::get('/fornecedores', [FornecedorController::class, 'index']);
Route::get('/fornecedores/{id}', [FornecedorController::class, 'show']);
Route::post('/fornecedores', [FornecedorController::class, 'store']);
Route::delete('/fornecedores/{id}', [FornecedorController::class, 'destroy']);