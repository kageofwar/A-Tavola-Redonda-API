<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    
    public function pedido_itens()
    {
        return $this->hasMany(PedidoItens::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
