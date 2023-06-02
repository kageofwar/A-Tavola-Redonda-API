<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\PedidoItens;
use App\Models\Produto;
use App\Models\Categoria;
use App\Http\Resources\PedidoResource;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PedidoController extends Controller
{
    public function index()
    {
        //$pedidos = Pedido::with('cliente', 'pedido_itens.produto.categoria')->get();
        $pedidos = QueryBuilder::for(Pedido::class)
        ->join("clientes", "clientes.id", "=", "pedidos.cliente_id")
        ->select("pedidos.*", "clientes.nome")
        ->allowedFilters([
            AllowedFilter::partial('clientes', 'clientes.nome'),
            AllowedFilter::scope('valor_menor_que'),
            AllowedFilter::scope('valor_maior_que'),
            "forma_pagamento",
            "status_pedido"
        ])
        ->get();

        
        foreach($pedidos as $pedido) {
            $pedido->itens = PedidoItens::select("quantidade", "produto_id")
            ->where('pedido_id', $pedido->id)
            ->get();
        }
        
        return PedidoResource::collection($pedidos); 
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $pedidos = new Pedido();
        $total = 0;
        DB::beginTransaction();
        $pedidos->cliente_id = $user->id;
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
        $pedidos->load('users', 'pedido_itens.produto.categoria');

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
        $user = auth()->user();
        $pedidos = Pedido::findOrFail($id);

        $pedidos->cliente_id = $user->id;
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
        $formasPagamento = ['Cartão de Crédito', 'Cartão de débito', 'Dinheiro'];
        $formasFormatado = [
            'Cartão de Crédito' => 'credito',
            'Cartão de débito' => 'debito',
            'Dinheiro' => 'dinheiro'
        ];
        $pedidos = [];

        foreach( $formasPagamento as $forma) {
            $pedidos[$formasFormatado[$forma]] = QueryBuilder::for(Pedido::class)
            ->AllowedFilters([
                'status_pedido',
                AllowedFilter::scope("data_antes_de"),
                AllowedFilter::scope("data_depois_de"),
            ])
            ->where( 'forma_pagamento', $forma) 
            ->sum("total");
        }
        return response()->json($pedidos);
     }

    public function por_status() {
        $allStatus = ['recebido', 'em_andamento', 'finalizado'];
        foreach($allStatus as $status) {
            $pedidos[$status] = QueryBuilder::for(Pedido::class)
            ->AllowedFilters([
                'forma_pagamento',
                AllowedFilter::scope("data_antes_de"),
                AllowedFilter::scope("data_depois_de"),
            ])
            ->where('status_pedido', $status)
            ->sum("total");

        }
        return response()->json($pedidos);
     }
    
    public function por_categoria() {
        $allCats = Categoria::select('nome', 'id')
        ->get();

        foreach($allCats as $cat) {
            $pedidoSum[$cat->nome] = 0;
            $i[$cat->id] = $cat->nome;
            $pedido[$cat->nome] = QueryBuilder::for(PedidoItens::class)
            ->join('produtos', 'pedido_itens.produto_id', '=', 'produtos.id')
            ->AllowedFilters([])
            ->where('produtos.categoria_id', $cat->id)
            ->get();
        }

        foreach($pedido as $item) {
            foreach($item as $produto) {
                $pedidoSum[$i[$produto->categoria_id]]  += (float)$produto->valor * (float)$produto->quantidade;
            }
        }
        return response()->json($pedidoSum);
    }

    // Metodo para trazer todos os pedidos feitos pelo usuario logado.
    public function pedidos_do_cliente()
    {
        $user = auth()->user();

        $PedidosUser = QueryBuilder::for(Pedido::class)
        ->join('users', 'pedidos.cliente_id', '=', 'users.id')
        ->get();

        dd($PedidosUser);
    }
}
