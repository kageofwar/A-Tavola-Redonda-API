<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::with('categoria')->get();

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
                'mensagem' => 'Produto Encontrado com Sucesso!',
                'produto' => $produtos
            ], 200);
        } else {
            return response()->json([
                'mensagem' => 'Produto não encontrado!',
            ], 404);
        }
    }

    public function update(Request $request, string $id)
    {
        $produtos = Produto::where('id', $id)->first();

        $produtos->nome = $request->input('nome');
        $produtos->descricao = $request->input('descricao');
        $produtos->valor = $request->input('valor');
        $produtos->categoria_id = $request->input('categoria_id');

        $produtos->update();

        return response()->json([
            'mensagem' => 'Produto Editado com sucesso!',
            'produto' => $produtos
        ], 200);
    }

    public function store(Request $request)
    {   
        $produtos =  new Produto();
        $produtos->nome = $request->input('nome');
        $produtos->descricao = $request->input('descricao');
        $produtos->valor = number_format($request->input('valor'), 2, "," ,".");
        $produtos->categoria_id = $request->input('categoria_id');

        $produtos->save();

        return response()->json([
            'mensagem' => 'Produto Cadastrado com sucesso!',
            'produto' => $produtos
        ], 200);
    }

    public function destroy(Request $request, $id)
    {
        $produtos = Produto::findOrFail($id);

        $produtos->delete();

        return response()->json([
            'mensagem' => 'Produto Deletado com sucesso!',
            'produto' => $produtos
        ], 200);
    }

}
