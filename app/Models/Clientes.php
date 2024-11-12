<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'nome',
        'email',
        'second_email',
        'telefone',
        'razao_social',
        'inscricao_estadual',
        'celular',
        'cep',
        'endereco',
        'bairro',
        'uf',
        'numero',
        'tipo_documento',
        'numero_transportadora',
        'responsavel_transportadora',
        'numero_documento',
        'transportadora',
    ];
}
