<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function index()
    {
        $categoria = Categoria::with('produto')->get();

        return response()->json([
            'mensagem' => 'Todas Categorias cadastradas',
            'categorias:' => $categoria
        ], 200);
    }

    public function show(Request $request, $id)
    {
        $categoria = Categoria::with('produto')->findOrFail($id);

        return response()->json([
            'mensagem' => 'Categoria encontrada!',
            'categorias:' => $categoria
        ], 200);
    }

    public function store(Request $request)
    {
        $categoria = new Categoria();

        $categoria->nome = $request->nome;

        $categoria->save();

        return response()->json([
            'mensagem' => 'Categoria cadastrada com sucesso!',
            'categorias:' => $categoria
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $categoria = Categoria::findOrFail($id);
        
        $categoria->nome = $request->nome;

        $categoria->update();

        return response()->json([
            'mensagem' => 'Categoria atualizada com sucesso!',
            'categorias:' => $categoria
        ], 200);
    }

    public function destroy(Request $request, $id)
    {
        $categoria = Categoria::findOrFail($id);

        $categoria->delete();

        return response()->json([
            'mensagem' => 'Categoria deletada com sucesso!',
            'categorias:' => $categoria
        ], 200);
    }
}
