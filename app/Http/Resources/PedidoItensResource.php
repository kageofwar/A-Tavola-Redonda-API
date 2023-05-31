<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProdutoResource;

class PedidoItensResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            //"id" => $this->id,
            "id" => $this->produto_id,
            "nome" => $this->produto->nome,
            "quantidade" => $this->quantidade,
            "descricao" => $this->produto->descricao,
            "unitario" => $this->produto->valor,
            "categoria" => $this->produto->categoria->nome,
            //"produto" => new ProdutoResource($this->produto)
        ];
    }
}
