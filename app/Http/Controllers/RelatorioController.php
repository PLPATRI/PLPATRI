<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Importe a classe DB

class RelatorioController extends Controller
{
    public function index()
    {
        // Inicializar variáveis com valores padrão
        $mes_01_25 = $mes_02_25 = $mes_03_25 = $mes_04_25 = $mes_05_25 = $mes_06_25 = 0;
        $mes_07_25 = $mes_08_25 = $mes_09_25 = $mes_10_25 = $mes_11_25 = $mes_12_25 = 0;

        // Consultas SQL usando Query Builder do Laravel
        $mes_01_25 = DB::table('pedidos')
            ->whereBetween('data', ['2025-01-01', '2025-01-31'])
            ->sum('valor');

        $mes_02_25 = DB::table('pedidos')
            ->whereBetween('data', ['2025-02-01', '2025-02-28'])
            ->sum('valor');

        $mes_03_25 = DB::table('pedidos')
            ->whereBetween('data', ['2025-03-01', '2025-03-31'])
            ->sum('valor');

        $mes_04_25 = DB::table('pedidos')
            ->whereBetween('data', ['2025-04-01', '2025-04-30'])
            ->sum('valor');

        $mes_05_25 = DB::table('pedidos')
            ->whereBetween('data', ['2025-05-01', '2025-05-31'])
            ->sum('valor');

        $mes_06_25 = DB::table('pedidos')
            ->whereBetween('data', ['2025-06-01', '2025-06-30'])
            ->sum('valor');

        $mes_07_25 = DB::table('pedidos')
            ->whereBetween('data', ['2025-07-01', '2025-07-31'])
            ->sum('valor');

        $mes_08_25 = DB::table('pedidos')
            ->whereBetween('data', ['2025-08-01', '2025-08-31'])
            ->sum('valor');

        $mes_09_25 = DB::table('pedidos')
            ->whereBetween('data', ['2025-09-01', '2025-09-30'])
            ->sum('valor');

        $mes_10_25 = DB::table('pedidos')
            ->whereBetween('data', ['2025-10-01', '2025-10-31'])
            ->sum('valor');

        $mes_11_25 = DB::table('pedidos')
            ->whereBetween('data', ['2025-11-01', '2025-11-30'])
            ->sum('valor');

        $mes_12_25 = DB::table('pedidos')
            ->whereBetween('data', ['2025-12-01', '2025-12-31'])
            ->sum('valor');

        // Dados para o gráfico de vendas mensais
        $data = [
            ['Mês', 'Vendas'],
            ['Jan', 'R$'.' '.(int)$mes_01_25],
            ['Fev', 'R$'.' '.(int)$mes_02_25],
            ['Mar', 'R$'.' '.(int)$mes_03_25],
            ['Abr', 'R$'.' '.(int)$mes_04_25],
            ['Mai', 'R$'.' '.(int)$mes_05_25],
            ['Jun', 'R$'.' '.(int)$mes_06_25],
            ['Jul', 'R$'.' '.(int)$mes_07_25],
            ['Ago', 'R$'.' '.(int)$mes_08_25],
            ['Set', 'R$'.' '.(int)$mes_09_25],
            ['Out', 'R$'.' '.(int)$mes_10_25],
            ['Nov', 'R$'.' '.(int)$mes_11_25],
            ['Dez', 'R$'.' '.(int)$mes_12_25],
        ];
        $jsonData = json_encode($data);

        // Consultar vendas por região
        $vendasPorRegiao = DB::table('pedidos')
            ->select(DB::raw("SUBSTRING_INDEX(endereco, ' - ', -1) AS regiao"), DB::raw("SUM(valor) AS total_vendas"))
            ->groupBy('regiao')
            ->get()
            ->pluck('total_vendas', 'regiao') // Cria um array associativo regiao => total_vendas
            ->toArray();

        $totalVendasBrasil = array_sum($vendasPorRegiao);


        // Retornar a View com os dados
        return view('relatorios', compact('jsonData', 'vendasPorRegiao', 'totalVendasBrasil'));
    }
}