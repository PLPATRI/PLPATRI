<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
    use HasFactory;

    protected $table = 'pedidos';
    protected $fillable = [
        "cliente_id",
        'razao_social',
        'cpf_cnpj',
        'desconto',
        'valor',
        'balcao',
        'endereco',
        'numero',
        'telefone',
        'data',
        'vendedor_id',
        'financeiro',
        'status',
        'confirmacao',
    ];

    public function cliente()
    {
        return $this->belongsTo(Clientes::class, 'cliente_id', 'id');
    }

    public function produtos()
    {
        return $this->hasMany(Produtos::class, 'id', 'produto_id');
    }

    public function items()
    {
        return $this->hasMany(PedidosItems::class, 'pedido_id', 'id');
    }

    public function vendedor()
{
    return $this->belongsTo(Vendedores::class, 'vendedor_id', 'id');
}
}
