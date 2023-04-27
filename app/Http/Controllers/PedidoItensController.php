<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PedidoItens;


class PedidoItensController extends Controller
{

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