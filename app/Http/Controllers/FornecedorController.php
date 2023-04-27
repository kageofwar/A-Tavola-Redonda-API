<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fornecedor;

class FornecedorController extends Controller
{
    public function index()
    {
        $fornecedores = Fornecedor::all();

        return response()->json([
            'mensagem' => 'Todos Fornecedores cadastrados',
            'fornecedores:' => $fornecedores
        ], 200);
    }

    public function show(Request $request, $id)
    {
        $fornecedores = Fornecedor::where('id', $id)->first();

        if($fornecedores)
        {
            return response()->json([
                'mensagem' => 'Fornecedor Encontrado com Sucesso!',
                'fornecedor' => $fornecedores
            ], 200);
        } else {
            return response()->json([
                'mensagem' => 'Fornecedor não encontrado!',
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
                'mensagem' => 'Fornecedor Cadastrado com sucesso!',
                'fornecedor Cadastrado' => $fornecedores
            ], 200);
    }

    public function update(Request $request, $id)
    {
        $fornecedores = Fornecedor::findOrFail($id);

        $fornecedores->nome = $request->input('nome');
        $fornecedores->telefone = $request->input('telefone');
        $fornecedores->email = $request->input('email');

        $fornecedores->update();

        return response()->json([
            'mensagem' => 'Fornecedor atualizado com sucesso!',
            'fornecedor:' => $fornecedores
        ], 200);
    }

    public function destroy(Request $request, $id)
    {
        $fornecedores = Fornecedor::findOrFail($id);

        $fornecedores->delete();

        return response()->json([
            'mensagem' => 'Fornecedor deletado com sucesso!',
            'fornecedor:' => $fornecedores
        ], 200);

    }
}
