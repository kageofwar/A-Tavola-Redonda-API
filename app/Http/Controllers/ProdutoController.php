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
            'mensagem' => 'Produtos no sistema.',
            'produto' => $produtos
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

    public function update(Request $request, $id)
    {
        $produtos = Produto::where('id', $id)->first();

        $produtos->nome = $request->input('nome');
        $produtos->valor = $request->input('valor');

        $produtos->update();

        return response()->json([
            'Mensagem' => 'Produto Editado com sucesso!',
            'Produto Cadastrado' => $produtos
        ], 200);
    }

    public function store(Request $request)
    {   
        $produtos =  new Produto();
        $produtos->nome = $request->input('nome');
        $produtos->valor = $request->input('valor');

        $produtos->save();

        return response()->json([
            'Mensagem' => 'Produto Cadastrado com sucesso!',
            'Produto Cadastrado' => $produtos
        ], 200);
    }

    public function destroy(string $id)
    {
        $produtos = Produto::findOrFail($id);

        $produtos->delete();
    }

}
