<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::all();

        return response()->json($produtos);
    }

    public function show(Request $request, $id)
    {
        $produtos = Produto::findOrFail($id);

        return response()->json([
            'Mensagem' => 'Produto Encontrado com Sucesso!',
            'Produto' => $produtos
        ], 200);
    }

    public function store(Request $request)
    {   
        $produtos =  new Produto();
        $produtos->nome = $request->input('nome');

        $produtos->save();

        return response()->json([
            'Mensagem' => 'GGWP',
        ], 200);
    }

}
