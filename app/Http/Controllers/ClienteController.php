<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    public function index()
    {
        $cliente = Cliente::with('pedido')->get();
        
        return response()->json([
            'mensagem' => 'Todos clientes cadastrados',
            'clientes:' => $cliente
        ], 200);
    }

    public function show(Request $request, $id)
    {
        $cliente = Cliente::with('pedido')->findOrFail($id);

        return response()->json([
            'mensagem' => 'Cliente encontrado!',
            'cliente:' => $cliente
        ], 200);
    }

    public function store(Request $request)
    {
        $cliente = new Cliente();

        $cliente->nome = $request->nome;

        $cliente->save();

        return response()->json([
            'mensagem' => 'cliente cadastrado com sucesso!',
            'cliente:' => $cliente
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);
        
        $cliente->nome = $request->nome;

        $cliente->update();

        return response()->json([
            'mensagem' => 'cliente atualizado com sucesso!',
            'cliente:' => $cliente
        ], 200);
    }

    public function destroy(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);

        $cliente->delete();

        return response()->json([
            'mensagem' => 'cliente deletado com sucesso!',
            'cliente:' => $cliente
        ], 200);
    }
}
