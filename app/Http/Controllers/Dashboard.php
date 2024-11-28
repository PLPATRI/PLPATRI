<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Cadastro\Produto;
use Illuminate\Http\Request;
use App\Models\Clientes;
use App\Models\Pedidos;
use App\Models\Produtos;
use Auth;
use Carbon\Carbon;

class Dashboard extends Controller
{
    public function index()
    {
        if (Auth::guard('vendedor')->check()) {
            Auth::guard('vendedor')->logout();
        }

        $totalClientes = Clientes::all()->count();
        $totalProdutos = Produtos::all()->count();
        $totalValorEstoque = Produtos::all()->sum(function ($produto) {
            return $produto->quantidade * $produto->preco_unitario;
        });

        $ultimosCarregamentos = Produtos::orderBy("created_at", "desc")->limit(10)->get()->toArray();

        $totalVendas = Pedidos::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('valor');


        $data = [
            "totalClientes" => $totalClientes,
            'totalProdutos' => $totalProdutos,
            'valorTotalEstoque' => $totalValorEstoque,
            'ultimosCarregamentos' => $ultimosCarregamentos,
            'totalVendasNoMes' => $totalVendas,
            'pedidos' => Pedidos::orderBy('created_at', 'desc')->limit(5)->get(),

        ];

        return view("dashboard", ['data' => $data]);
    }
}