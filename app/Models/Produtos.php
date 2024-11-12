<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Fornecedores;

class Produtos extends Model
{
    use HasFactory;

    protected $table = 'produtos';

    protected $fillable = [
        'referencia',
        'modelo',
        'fornecedor_id',
        'preco_unitario',
        'data',
        'quantidade',
        'estoque_seguranca'
    ];

    public function fornecedor()
    {
        return $this->belongsTo(Fornecedores::class, 'fornecedor_id', 'id');
    }
}
