<?php

namespace App\Http\Controllers\Pedidos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NovoPedido extends Controller
{
    public function index()
    {
        return view("pedidos.novo_pedido");
    }
}
