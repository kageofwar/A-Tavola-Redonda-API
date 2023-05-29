<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\PedidoItens;
use App\Models\Produto;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with('cliente', 'pedido_itens.produto.categoria')->get();

        return response()->json([
            'mensagem' => 'Todos Pedidos cadastrados',
            'pedidos' => $pedidos
        ], 200);
    }

    public function store(Request $request)
    {
        $pedidos = new Pedido();
        $total = 0;
        DB::beginTransaction();
        $pedidos->cliente_id = $request->input('cliente_id');
        $pedidos->forma_pagamento = $request->input('forma_pagamento');
        $pedidos->status_pedido = "recebido";
        $pedidos->total = 0;
        if(!$pedidos->save()) {
            return DB::rollback();
        }

        $itens = $request->input('itens');
        
        foreach($itens as $item) {
           $produto = Produto::find($item['produto_id']);
           $total += (float)$item["quantidade"] * (float)$produto['valor'];
           $pedidoItems = PedidoItens::create([ 
               'pedido_id' => $pedidos['id'],
               'produto_id' => $item['produto_id'],
               'quantidade' => $item['quantidade'],
           ]);
        }
        

        $pedidos->total = $total;
        $pedidoSalvo = $pedidos->save();
        if($pedidoSalvo){
            DB::commit();
        } else {
            DB::rollback();
        }
        $pedidos->load('cliente', 'pedido_itens.produto.categoria');

        return response()->json([
            'mensagem' => 'Pedido criado com sucesso',
            'pedido' => $pedidos,
        ]);
    }

    public function show(Request $request, $id)
    {
        $pedidos = Pedido::with('cliente', 'pedido_itens.produto.categoria')->findOrFail($id);

        if($pedidos)
        {
            return response()->json([
                'mensagem' => 'Pedido Encontrado com Sucesso!',
                'pedido' => $pedidos
            ], 200);
        } else {
            return response()->json([
                'mensagem' => 'Pedido não encontrado!',
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $pedidos = Pedido::findOrFail($id);

        $pedidos->cliente_id = $request->input('cliente_id');
        $pedidos->status_pedido = $request->input('status_pedido');
        $pedidos->forma_pagamento = $request->input('forma_pagamento');

        $pedidos->update();

        return response()->json([
            'mensagem' => 'Pedido Atualizado com sucesso',
            'pedido' => $pedidos
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $itens = PedidoItens::where('pedido_id', '=', $id);

        $itens->delete();

        $pedidos = Pedido::findOrFail($id);

        $pedidos->delete();

        return response()->json([
            'mensagem' => 'Pedido excluido com sucesso',
            'pedido' => $pedidos
        ]);
    }
    //funcoes para resgatar dados dos pedidos para exibicao em graficos no front. Ex: total por tipo de pagamento, total por produto, total por categoria etc....
     public function por_pagamento() {
        $pedidos = Pedido::where("forma_pagamento", "dinheiro")
        ->where("status_pedido", "finalizado")
        ->sum("total");
        return response()->json($pedidos);
     }
}
