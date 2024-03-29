<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\ProdutoResource;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = QueryBuilder::for(Produto::class)
        ->join("categorias", "categorias.id", "=", "produtos.categoria_id")
        ->select("categorias.nome", "produtos.*")
        ->allowedFilters([
            AllowedFilter::partial('categorias','categoria.nome'),
            "nome"
            ])
        ->paginate(10);

        return ProdutoResource::collection($produtos);
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
        $user = auth()->user();

        if ($user->hasRole('Adminstrador')) {
            
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
        } else {
            return response()->json([
                'mensagem' => 'Somente administradores podem editar os produtos.'
            ], 401);
        }
    }

    public function store(Request $request)
    {   
        //$user = auth()->user();

        //if ($user->hasRole('Adminstrador')) {
            $produtos =  new Produto();
            $produtos->nome = $request->input('nome');
            $produtos->descricao = $request->input('descricao');
            $produtos->valor = number_format($request->input('valor'), 2, "," ,".");
            $produtos->categoria_id = $request->input('categoria_id') ? $request->input('categoria_id') : "";

            $produtos->save();

            return response()->json([
                'mensagem' => 'Produto Cadastrado com sucesso!',
                'produto' => $produtos
            ], 200);
        //} else {
        //    return response()->json([
        //        'mensagem' => 'Somente administradores podem cadastrar novos produtos.'
        //    ], 401);
        //}
    }

    public function destroy(Request $request, $id)
    {
        //$user = auth()->user();

        //if ($user->hasRole('Adminstrador')) {
            $produtos = Produto::findOrFail($id);

            $produtos->delete();

            return response()->json([
                'mensagem' => 'Produto Deletado com sucesso!',
                'produto' => $produtos
            ], 200);
        //} else {
        //    return response()->json([
        //        'mensagem' => 'Somente administradores podem deletar os produtos.'
        //    ], 401);
        //}
    }

}
