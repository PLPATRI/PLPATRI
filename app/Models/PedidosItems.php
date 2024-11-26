<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PedidosItems extends Model
{
    use HasFactory;


    protected $table = 'pedido_items';

    protected $fillable = [
        'produto_id',
        "pedido_id",
        "quantidade",
        "valor_unitario",
        "modelo",
        "valor_total",
    ];

    public function pedidos()
    {
        return $this->hasOne(Pedidos::class, 'id', 'pedido_id');
    }

    public function produto()
    {
        return $this->hasOne(Produtos::class, 'id', 'produto_id');
    }
}
