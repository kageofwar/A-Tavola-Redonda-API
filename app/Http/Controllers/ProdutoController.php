<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::all();

        return response()->json([
            'Mensagem' => 'Produtos no sistema.',
            'Produto' => $produtos
        ], 200);
    }

    public function show(Request $request, $id)
    {
        $produtos = Produto::where('id', $id)->first();

        if($produtos)
        {
            return response()->json([
                'Mensagem' => 'Produto Encontrado com Sucesso!',
                'Produto' => $produtos
            ], 200);
        } else {
            return response()->json([
                'Mensagem' => 'Produto não encontrado!',
            ], 404);
        }
    }

    public function store(Request $request)
    {   
        $produtos =  new Produto();
        $produtos->nome = $request->input('nome');
        $produtos->fornecedor_id = $request->input('fornecedor_id');

        $produtos->save();

        return response()->json([
            'Mensagem' => 'Produto Cadastrado com sucesso!',
            'Produto Cadastrado' => $produtos
        ], 200);
    }

    public function destroy(Request $request)
    {
        $produtos = Produto::findOrFail($id);

        $produtos->delete();
    }

}
