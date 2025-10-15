<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Importe a classe DB
use App\Models\PedidosItems; // Corrija a importação para o modelo PedidoItem
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
    
   
    

 
public function vendedores(Request $request)
{
    // Obter o ano selecionado ou o ano atual
    $anoSelecionado = $request->input('ano', date('Y'));  // Se não tiver um ano selecionado, usa o ano atual

    // Obter a ordem de classificação (asc ou desc)
    $order = $request->input('order', 'asc');  // Padrão é crescente

    // Consultar os dados de vendas, agrupando por vendedor_id
    $vendedores = DB::table('pedidos')
        ->join('vendedores', 'pedidos.vendedor_id', '=', 'vendedores.id') // Relaciona a tabela pedidos com vendedores
        ->select('vendedores.usuario as nome_vendedor', DB::raw('SUM(pedidos.valor) as total_vendas')) // Soma o valor das vendas por vendedor
        ->whereYear('pedidos.created_at', '=', $anoSelecionado) // Filtra pelo ano selecionado
        ->groupBy('pedidos.vendedor_id', 'vendedores.usuario') // Agrupa por vendedor
        ->orderBy('total_vendas', $order) // Ordena pelo total de vendas
        ->get();

    // Preparar os dados para a view
    $labels = $vendedores->pluck('nome_vendedor')->toArray();  // Nomes dos vendedores
    $data = $vendedores->pluck('total_vendas')->toArray();  // Total de vendas de cada vendedor

    // Retornar a view com os dados necessários
    return view('relatorios.vendedores', compact('vendedores', 'labels', 'data', 'order', 'anoSelecionado'));
}



    // Método para gerar o relatório da Curva ABC
    public function curva(Request $request)
    {
        // Lógica para calcular a Curva ABC
        $anoSelecionadoABC = $request->input('ano', date('Y')); // Exemplo de captura de ano
        $anosDisponiveis = [2023, 2024, 2025]; // Exemplo de anos disponíveis

        // Recuperando os dados da tabela pedido_items
        $pedidoItems = PedidosItems::select('modelo', 'quantidade', 'produto_id', 'pedido_id', 'valor_total')
            ->get(); // Usamos `get()` para recuperar todos os registros

        // Processando os dados para gerar a Curva ABC
        $produtosABC = $pedidoItems->map(function ($item) {
            return [
                'nome' => $item->modelo, // Isso pode ser alterado para pegar o nome real do produto
                'total_vendas' => $item->quantidade * $item->valor_total, // Exemplo de cálculo do total de vendas
                'cumulativo' => 0, // Lógica de cálculo cumulativo será adicionada aqui
                'classe' => $this->determineClasse($item->quantidade * $item->valor_total), // Lógica de definição de classe
            ];
        });

        // Certifique-se de que seja uma coleção do Laravel
        $produtosABC = collect($produtosABC);

        // Passando a coleção para a view
        return view('relatorios.curva', compact('produtosABC', 'anoSelecionadoABC', 'anosDisponiveis'));
    }

    // Exemplo de função para determinar a classe A, B ou C
    private function determineClasse($valorTotal)
    {
        if ($valorTotal > 5000) {
            return 'A';
        } elseif ($valorTotal > 3000) {
            return 'B';
        } else {
            return 'C';
        }
    }


public function show($anoSelecionadoABC)
{
    // Defina a quantidade de itens por página, com valor padrão de 10
    $quantidadePorPagina = request()->get('quantidade', 10);

    // Use paginate() para garantir que você está trabalhando com um objeto LengthAwarePaginator, não uma Collection
    $produtosABC = Produto::where('ano', $anoSelecionadoABC)
                          ->paginate($quantidadePorPagina);

    // Verifique o conteúdo de $produtosABC
    dd($produtosABC);  // Aqui você verá se está retornando um LengthAwarePaginator

    return view('relatorios.curva_abc', compact('produtosABC', 'anoSelecionadoABC'));
}




// relatorio clientes

public function clientes(Request $request)
{
    // Definir a direção de ordenação padrão como 'desc' (mais compraram)
    $ordem = $request->input('ordem', 'desc');  // 'desc' ou 'asc'

    // Recuperar pedidos com o total de compras, sem considerar o ano
    $compradores = DB::table('pedidos')
        ->select('pedidos.razao_social', 'pedidos.cpf_cnpj', 'pedidos.telefone', DB::raw('SUM(pedidos.valor) as total_compras'))
        ->groupBy('pedidos.razao_social', 'pedidos.cpf_cnpj', 'pedidos.telefone')
        ->orderBy('total_compras', $ordem) // Ordenar conforme a direção (asc ou desc)
        ->paginate(15); // Adicionar paginação (10 resultados por página)

    // Passar os dados para a view
    return view('relatorios.clientes', compact('compradores', 'ordem'));
}



// relatorio anual

  public function anual(Request $request)
{
    // Definindo os anos disponíveis
    $anosDisponiveis = [2025, 2026];
    
    // Definindo o ano selecionado a partir da requisição, ou o ano atual como padrão
    $anoSelecionadoanual = $request->input('ano', 2025);
    
    // Consultando os dados de vendas por mês para o ano de 2025
    $vendas2025Query = DB::table('pedidos')
        ->select(
            DB::raw('MONTH(data) as mes'), 
            DB::raw('SUM(valor_original) as total_vendas')
        )
        ->whereYear('data', 2025)
        ->groupBy(DB::raw('MONTH(data)'))
        ->get();
    
    // Consultando os dados de vendas por mês para o ano de 2026
    $vendas2026Query = DB::table('pedidos')
        ->select(
            DB::raw('MONTH(data) as mes'), 
            DB::raw('SUM(valor_original) as total_vendas')
        )
        ->whereYear('data', 2026)
        ->groupBy(DB::raw('MONTH(data)'))
        ->get();
    
    // Formatando os dados para o formato esperado pelo Chart.js (array de 12 posições)
    $vendas2025 = array_fill(0, 12, 0); // Inicializa array com zeros para os 12 meses
    $vendas2026 = array_fill(0, 12, 0); // Inicializa array com zeros para os 12 meses
    
    // Preenche o array com os valores reais de vendas
    foreach ($vendas2025Query as $venda) {
        $mes = $venda->mes - 1; // Ajusta para índice zero-based (jan=0, fev=1, etc)
        $vendas2025[$mes] = (float)$venda->total_vendas;
    }
    
    foreach ($vendas2026Query as $venda) {
        $mes = $venda->mes - 1; // Ajusta para índice zero-based
        $vendas2026[$mes] = (float)$venda->total_vendas;
    }
    
    // Passando os dados para a view
    return view('relatorios.anual', [
        'vendas2025' => $vendas2025,
        'vendas2026' => $vendas2026,
        'anosDisponiveis' => $anosDisponiveis,
        'anoSelecionadoanual' => $anoSelecionadoanual,
    ]);
}








}