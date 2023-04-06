<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fornecedor;

class FornecedorController extends Controller
{
    public function index()
    {
        $fornecedores = Fornecedor::all();

        return $fornecedores;
    }

    public function show(Request $request, $id)
    {
        $fornecedores = Fornecedor::where('id', $id)->first();

        if($fornecedores)
        {
            return response()->json([
                'Mensagem' => 'Produto Encontrado com Sucesso!',
                'Produto' => $fornecedores
            ], 200);
        } else {
            return response()->json([
                'Mensagem' => 'Produto não encontrado!',
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $fornecedores =  new Fornecedor();
            $fornecedores->nome = $request->input('nome');
            $fornecedores->telefone = $request->input('telefone');
            $fornecedores->email = $request->input('email');
    
            $fornecedores->save();
    
            return response()->json([
                'Mensagem' => 'Produto Cadastrado com sucesso!',
                'Produto Cadastrado' => $fornecedores
            ], 200);
    }
}
