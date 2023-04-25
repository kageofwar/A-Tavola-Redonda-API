<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with('cliente', 'pedido_itens.produto.categoria')->get();

        return response()->json([
            'mensagem' => 'Todos Pedidos cadastrados',
            'Pedidos:' => $pedidos
        ], 200);
    }

    public function store(Request $request)
    {
        $pedidos = new Pedido();

        $pedidos->cliente_id = $request->input('cliente_id');
        $pedidos->Status = $request->input('Status');
        $pedidos->forma_pagamento = $request->input('forma_pagamento');

        $pedidos->save();

        return response()->json([
            'mensagem' => 'Pedido criado com sucesso',
            'Pedido' => $pedidos
        ]);
    }

    public function show(Request $request, $id)
    {
        $pedidos = Pedido::with('cliente', 'pedido_itens.produto.categoria')->findOrFail($id);

        if($pedidos)
        {
            return response()->json([
                'Mensagem' => 'Pedido Encontrado com Sucesso!',
                'Pedido' => $pedidos
            ], 200);
        } else {
            return response()->json([
                'Mensagem' => 'Pedido não encontrado!',
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $pedidos = Pedido::findOrFail($id);

        $pedidos->cliente_id = $request->input('cliente_id');
        $pedidos->Status = $request->input('Status');
        $pedidos->forma_pagamento = $request->input('forma_pagamento');

        $pedidos->update();

        return response()->json([
            'Mensagem' => 'Pedido Atualizado com sucesso',
            'Pedido' => $pedidos
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $pedidos = Pedido::findOrFail($id);

        $pedidos->delete();

        return response()->json([
            'Mensagem' => 'Pedido excluido com sucesso',
            'Pedido' => $pedidos
        ]);
    }
}
