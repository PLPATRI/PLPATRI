<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Importe a classe DB
use Carbon\Carbon;

class RelatorioController extends Controller
{
     /**
     * Exibe o relatório de vendas mensais com filtro de ano.
     *
     * @param Request $request  <---- ADICIONE OU VERIFIQUE ISTO
     * @return \Illuminate\Contracts\View\View
     */
    public function funil(Request $request)
    {
         // 1. Determinar o ano a ser exibido
        // Pegue o ano do request, se não houver, use o ano atual
        $anoSelecionado = $request->input('ano', date('Y'));

        // 2. Buscar dados de vendas mensais para o ano selecionado em UMA ÚNICA CONSULTA
        $vendasPorMesQuery = DB::table('pedidos')
            ->select(
                DB::raw('MONTH(data) as mes'), // Extrai o número do mês
                DB::raw('SUM(valor) as total_vendas') // Soma os valores
            )
            ->whereYear('data', $anoSelecionado) // Filtra pelo ano selecionado
            ->groupBy('mes') // Agrupa pelo mês
            ->orderBy('mes', 'asc') // Ordena pelo mês
            ->pluck('total_vendas', 'mes'); // Retorna um array associativo [mes => total_vendas]

        // 3. Preparar os dados para o gráfico (garantindo todos os 12 meses)
        $labelsMeses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
        $dadosVendas = [];

        for ($mes = 1; $mes <= 12; $mes++) {
            // Verifica se existe valor para o mês na consulta, senão usa 0
            $dadosVendas[] = $vendasPorMesQuery->get($mes, 0);
        }

        // 4. (Opcional) Buscar anos disponíveis para o filtro (melhora a UX)
        $anosDisponiveis = DB::table('pedidos')
                           ->select(DB::raw('DISTINCT YEAR(data) as ano'))
                           ->orderBy('ano', 'desc')
                           ->pluck('ano');
        
        // Se não houver pedidos, adicione o ano atual como opção
        if ($anosDisponiveis->isEmpty()) {
            $anosDisponiveis = collect([date('Y')]);
        }


        // 5. (Opcional - Mantido da sua lógica original, ajuste se necessário)
        // Consultar vendas por região (se ainda for necessário nesta view)
        // Note que isso NÃO está filtrado por ano na sua lógica original.
        // Se precisar filtrar por ano, adicione ->whereYear('data', $anoSelecionado)
        $vendasPorRegiao = DB::table('pedidos')
            ->select(DB::raw("SUBSTRING_INDEX(endereco, ' - ', -1) AS regiao"), DB::raw("SUM(valor) AS total_vendas"))
            // ->whereYear('data', $anoSelecionado) // Adicione se quiser filtrar por ano
            ->groupBy('regiao')
            ->pluck('total_vendas', 'regiao')
            ->toArray();

        $totalVendasBrasil = array_sum($vendasPorRegiao);


        


        // 6. Retornar a View com os dados
        return view('relatorios/funil', compact(
            'labelsMeses',      // Nomes dos meses para o gráfico
            'dadosVendas',      // Valores de vendas para o gráfico
            'anoSelecionado',   // Ano que está sendo exibido
            'anosDisponiveis',  // Anos para popular o dropdown de filtro
            'vendasPorRegiao',  // Dados de vendas por região (opcional)
            'totalVendasBrasil' // Total de vendas Brasil (opcional)
        ));
    }
    
    public function vendedores()
    {
    


        // Retornar a View com os dados
        return view('relatorios/vendedores');
    }

    public function curva()
    {
    
        // Retornar a View com os dados
        return view('relatorios/curva');
    }
}