<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PedidoItensResource;

class PedidoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "cliente" => $this->cliente,
            "itens" => PedidoItensResource::collection($this->itens),
            "forma_pagamento" => $this->forma_pagamento,
            "status_pedido" => $this->status_pedido,
            "total" => $this->total,
        ];
    }
}
