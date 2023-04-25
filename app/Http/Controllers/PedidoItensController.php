<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PedidoItens;


class PedidoItensController extends Controller
{
    public function store(Request $request)
    {
        $itens = new PedidoItens();

        $itens->pedido_id = $request->input('pedido_id');
        $itens->produto_id = $request->input('produto_id');
        $itens->quantidade = $request->input('quantidade');

        $itens->save();

        return response()->json([
            'Mensagem' => 'Item adicionado com sucesso',
            'Item' => $itens
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $itens = PedidoItens::findOrFail($id);

        $itens->delete();
    }

    public function ListarItensdoPedido(Request $request, $id)
    {
        $itens = PedidoItens::where('pedido_id', $id)->get();

        return $itens;
    }
}