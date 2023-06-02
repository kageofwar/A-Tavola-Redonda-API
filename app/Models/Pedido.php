<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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
    
    public function scopeValorMaiorQue(Builder $query, $valor): Builder {
        return $query->where('total', ">=", $valor);
    }

    public function scopeValorMenorQue(Builder $query, $valor): Builder {
        return $query->where('total', "<=", $valor);
    }
    
    public function scopeDataDepoisDe(Builder $query, $data): Builder {
        return $query->where('created_at', ">=" , Carbon::parse($data));
    }

    public function scopeDataAntesDe(Builder $query, $data): Builder {
        return $query->where('created_at', "<=" , Carbon::parse($data));
    }
}
