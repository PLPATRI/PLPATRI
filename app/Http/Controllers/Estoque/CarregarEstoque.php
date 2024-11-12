<?php

namespace App\Http\Controllers\Estoque;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CarregarEstoque extends Controller
{
    public function index()
    {
        return view("estoque/carregar_estoque");
    }
}
