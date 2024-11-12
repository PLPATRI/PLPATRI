<?php

namespace App\Http\Controllers\Pedidos;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class Pedidos extends Controller
{
    public function index()
    {
        return view("pedidos.pedidos");
    }
}
