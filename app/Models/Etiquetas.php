<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etiquetas extends Model
{
    use HasFactory;

    protected $table = 'etiquetas';

    protected $fillable = [
        "razao_social",
        "cliente_id",
        "CEP",
        "cidade",
        "rua",
        "numero",
        "bairro",
    ];

    public function clientes()
    {
        return $this->hasMany(Clientes::class, 'id', 'cliente_id');
    }
}
