<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProdutoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "nome" => $this->nome,
            "id" => $this->id,
            "descricao" => $this->descricao,
            "valor" => $this->valor,
            "categoria" => $this->categoria->nome,
            "categoria_id" => $this->categoria_id,
        ];
    }
}
