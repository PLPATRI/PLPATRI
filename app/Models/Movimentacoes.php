<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimentacoes extends Model
{
    use HasFactory;

    protected $table = 'movimentacoes';
    protected $fillable = [
        'referencia',
        'modelo',
        'compra',
        'baixa',
        'estoque',
        'data_reposicao',
        'data_baixa',
        'fornecedor',
        'valor_unitario',
        'valor_total'
    ];
}
