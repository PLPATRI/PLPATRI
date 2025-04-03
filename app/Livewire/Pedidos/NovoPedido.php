<?php

namespace App\Livewire\Pedidos;

use App\Models\Clientes;
use App\Models\Fornecedores;
use App\Models\Movimentacoes;
use App\Models\Pedidos;
use App\Models\PedidosItems;
use App\Models\Produtos;
use App\Models\Configuracoes;
use Livewire\WithPagination;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class NovoPedido extends Component
{
    use WithPagination;

    public $numero_documento = '';
    public $nomeCliente = '';
    public $cliente;
    public $pedidos = [];
    public $produtos;
    public $quantidades = [];
    public $valorUnitarios = [];
    public $valorTotal = 0.0; // <- Sempre será o valor original (sem desconto)
    public $valorTotalComDesconto = 0.0; // <- Valor final (com desconto aplicado)
    public $observacao = '';

    public $configuracoes;
    public $paginate;
    public $totalPaginate;

    public $desconto = 0.0; // <- Porcentagem do desconto
    public $produtosSelecionados = [];

    public $referencia_inicial = 1;
    public $referencia_final = '';

    public $produtosMarcados = [];

    public $modelo = '';

    public $fornecedor = '';
    public $fornecedorSelecionado = '';

    public $bloquear_input = [];

    public $produtosEscolhidos = [];

    public $showModal = false;
    public $showModalCliente = true;

    // Removido $descontoAplicado, usaremos apenas $desconto
    // public $descontoAplicado = 0;

    public $metodoEntrega = '';
    public $endereco = '';
    public $numero = '';

    public $clientes = [];
    public $modalAberta = true;
    public $fornecedores;

    public function mount()
    {
        if (session()->has('clientePedido')) {
            $this->cliente = session()->get('clientePedido');
            $this->numero_documento = $this->cliente->numero_documento;
            $this->buscarPedidos();
            session()->forget('clientePedido');
            $this->showModalCliente = false;
        }
        $this->atualizarProdutos();
        $this->fornecedores = Fornecedores::all();
        $this->inicializarValores(); // Garante que os totais estejam sincronizados inicialmente
    }

    // Função auxiliar para inicializar/resetar valores
    private function inicializarValores()
    {
        $this->valorTotal = array_sum($this->valorUnitarios);
        $this->aplicaDesconto(); // Calcula o valor com desconto baseado no valorTotal e desconto atuais
    }

    public function updated()
    {
        // Não chamar atualizarProdutos aqui sempre pode causar loops indesejados
        // Chame-o apenas quando propriedades específicas de filtro mudarem, se necessário
        // ou deixe o Livewire lidar com isso automaticamente para os `wire:model`.
    }

    public function atualizarProdutos()
    {
        // ... (seu código de atualização de produtos existente) ...
         $this->configuracoes = Configuracoes::first();
        $this->paginate = $this->configuracoes ? $this->configuracoes->numero_itens_tabelas : 10;

        $query = Produtos::query();

        if ($this->referencia_inicial != '') {
            $query->where('referencia', '>=', $this->referencia_inicial);
        }

        if ($this->referencia_final != '') {
            $query->where('referencia', '<=', $this->referencia_final);
        }

        if ($this->modelo != '') {
            $query->where('modelo', 'like', '%' . $this->modelo . '%');
        }

         if ($this->fornecedorSelecionado != '') {
            $query->where('fornecedor_id', $this->fornecedorSelecionado);
        }

        $query->orderByRaw('
            CAST(REGEXP_REPLACE(referencia, "[^0-9]", "") AS UNSIGNED),
            CASE
                WHEN referencia REGEXP "[A-Z]"
                THEN SUBSTRING(referencia, REGEXP_INSTR(referencia, "[A-Z]"))
                ELSE referencia -- Ou apenas a string completa como fallback
            END ASC
        ');

        // Paginação padrão
        $produtosPaginator = $query->with('fornecedor')->paginate($this->paginate);

        // Ajustando para limitar os links visíveis
        $currentPage = $produtosPaginator->currentPage();
        $lastPage = $produtosPaginator->lastPage();

        $startPage = max(1, $currentPage - 1); // Mostra uma página antes
        $endPage = min($lastPage, $currentPage + 1); // Mostra uma página depois

        $visiblePages = range($startPage, $endPage);

        $this->produtos = $produtosPaginator->toArray();
        $this->produtos['visiblePages'] = $visiblePages; // Adiciona as páginas visíveis para o Livewire
    }


    public function atualizarPagina($pagina)
    {
        $this->setPage($pagina);
        $this->atualizarProdutos();
    }

    public function buscarPedidos()
    {
       // ... (seu código de busca de pedidos existente) ...
        if ($this->numero_documento == '' && $this->nomeCliente == '') {
            toastr('Informe o número do documento ou o nome do cliente.', 'error');
            return;
        }

        if ($this->numero_documento !== '') {
            $this->cliente = Clientes::where('numero_documento', 'like', '%' . $this->numero_documento . '%')->first();
        } elseif ($this->nomeCliente !== '') {
            $this->cliente = Clientes::where('nome', 'like', '%' . $this->nomeCliente . '%')->first();
        } else {
            toastr('Informe o número do documento ou o nome do cliente.', 'error');
            return;
        }

        if (!$this->cliente) {
            toastr('Cliente não encontrado.', 'error');
            return;
        }

        if ($this->cliente) {
            $pedido = Pedidos::where('cliente_id', $this->cliente->id)
                ->orderBy('id', 'desc')
                ->get();
            if ($pedido->count() > 0) {
                foreach ($pedido as $key => $value) {
                    $items = PedidosItems::where('pedido_id', $value['id'])
                        ->get()
                        ->toArray();

                    $this->pedidos[$value['id']] = [
                        'id' => $value['id'],
                        'quantidade' => $value['quantidade'],
                        'referencia' => $value['referencia'],
                        'desconto' => $value['desconto'],
                        'razao_social' => $value['razao_social'],
                        'cpf_cnpj' => $value['cpf_cnpj'],
                        'balcao' => $value['balcao'],
                        'telefone' => $value['telefone'],
                        'data' => $value['data'],
                        'valor' => $value['valor'], // <- Valor final já com desconto (do pedido antigo)
                        'valor_original' => $value['valor_original'], // <- Valor original (do pedido antigo)
                        'financeiro' => $value['financeiro'],
                        'status' => $value['status'],
                        'confirmacao' => $value['confirmacao'],
                        'items' => [],
                    ];

                    foreach ($items as $keyItems => $valueItems) {
                        $this->pedidos[$value['id']]['items'][] = [
                            'id' => $valueItems['id'],
                            'quantidade' => $valueItems['quantidade'],
                            'valor_unitario' => $valueItems['valor_unitario'],
                            'modelo' => $valueItems['modelo'],
                            'valor_total' => $valueItems['valor_total'],
                        ];
                    }
                }
                $this->dispatch('closeModal');
            } else {
                $this->pedidos = [];
                $this->dispatch('closeModal');
            }
        } else {
            toastr('Cliente não encontrado.', 'error');
        }
    }

    public function render()
    {
        // Garante que os produtos na view tenham os valores corretos de quantidade e valor_total
         $produtosData = [];
         if (isset($this->produtos['data']) && is_array($this->produtos['data'])) {
             $produtosData = array_map(function ($produto) {
                 $produto['quantidade'] = $this->quantidades[$produto['id']] ?? 0;
                 // O valor_total aqui é o valor do item individual, não o total geral
                 // O cálculo já é feito em calcula() e armazenado em $valorUnitarios
                 $produto['valor_total_item'] = $this->valorUnitarios[$produto['id']] ?? 0;
                 return $produto;
             }, $this->produtos['data']);
         }

        return view('livewire.pedidos.novo-pedido', [
            'pedidos' => $this->pedidos,
            'cliente' => $this->cliente,
            'clientes' => $this->clientes,
            'modalAberta' => $this->modalAberta,
            'produtos' => $produtosData, // Passa os dados processados
             'paginationLinks' => $this->produtos, // Passa o array original para links de paginação
            'fornecedores' => $this->fornecedores,
        ]);
    }


    public function calcula($quantidade, $valorUnitario, $produto_id)
    {
        $this->quantidades[$produto_id] = $quantidade;
        $retorno = $valorUnitario * $quantidade;

        $produto = Produtos::find($produto_id);

        // Adiciona ou atualiza o produto selecionado
        $this->produtosSelecionados[$produto_id] = [
            'id' => $produto_id,
            'quantidade' => $quantidade,
            'modelo' => $produto->modelo,
            'referencia' => $produto->referencia,
            'preco_unitario' => $valorUnitario,
            'valor_total' => $retorno, // Valor total deste item
        ];

        // Atualiza o array de totais por item
        $this->valorUnitarios[$produto_id] = $retorno;

        // Recalcula o valor total original e aplica o desconto
        $this->inicializarValores();

        // Não retorna nada, pois as propriedades $valorTotal e $valorTotalComDesconto são atualizadas
    }

    public function toggleProduto($produtoId)
    {
        if (in_array($produtoId, $this->produtosMarcados)) {
            // Remove o produto
            $this->produtosMarcados = array_filter($this->produtosMarcados, function ($id) use ($produtoId) {
                return $id != $produtoId;
            });
            unset($this->produtosSelecionados[$produtoId]);
            unset($this->valorUnitarios[$produtoId]);
            // Zera a quantidade para este produto se necessário
             $this->quantidades[$produtoId] = 0;
        } else {
            // Adiciona o produto
            $this->produtosMarcados[] = $produtoId;
            $quantidade = $this->quantidades[$produtoId] ?? 0;
            $produto = Produtos::find($produtoId);
            if ($produto) {
                // Calcula o valor inicial deste item (pode ser 0 se a quantidade for 0)
                $this->calcula($quantidade, $produto->preco_unitario, $produtoId);
            }
        }

        // Recalcula o valor total original e aplica o desconto após adicionar/remover
        $this->inicializarValores();
    }

    /**
     * Calcula o valorTotalComDesconto baseado no valorTotal e na porcentagem de desconto.
     * Esta função agora é o ponto central para calcular o valor final.
     */
    public function aplicaDesconto()
    {
        // Garante que o desconto seja numérico e não negativo
        $this->desconto = is_numeric($this->desconto) && $this->desconto >= 0 ? (float) $this->desconto : 0.0;

        if ($this->desconto > 0 && $this->valorTotal > 0) {
            $descontoValor = $this->valorTotal * ($this->desconto / 100);
            $this->valorTotalComDesconto = $this->valorTotal - $descontoValor;
        } else {
            // Se não há desconto ou valor, o valor com desconto é igual ao original
            $this->valorTotalComDesconto = $this->valorTotal;
        }
        // Não precisa mais do botão para "aplicar", pois o cálculo é feito
        // sempre que o $valorTotal ou $desconto muda (ou quando chamado explicitamente).
        // O botão na view pode ser removido ou apenas servir como um gatilho visual
        // se você ainda quiser que o usuário clique nele para ver a mudança.
    }

    // Este método pode ser chamado pelo botão se você ainda quiser a ação de clique,
    // mas o cálculo principal já está em aplicaDesconto().
    public function recalcularComDescontoClick()
    {
         $this->aplicaDesconto();
         // Opcional: Adicionar feedback ao usuário
         // toastr('Desconto recalculado.', 'info');
    }

    public function gerarPedido()
    {
        if (empty($this->produtosSelecionados)) {
            toastr('Selecione os itens e a quantidade de cada item corretamente', 'error');
            return;
        }

        // Garante que os produtos escolhidos reflitam o estado atual
        $this->produtosEscolhidos = $this->produtosSelecionados;
        // Garante que o cálculo do desconto esteja atualizado antes de mostrar o modal
        $this->aplicaDesconto();
        $this->showModal = true;
    }

    public function limparCesta()
    {
        $this->produtosSelecionados = [];
        $this->produtosMarcados = [];
        $this->quantidades = [];
        $this->valorUnitarios = [];
        $this->desconto = 0.0;
        $this->inicializarValores(); // Reseta os totais
        // Não redireciona mais, apenas limpa o estado atual
         toastr('Cesta limpa.', 'success');
        // return redirect('/novo-pedido'); // Remover redirecionamento
    }

    public function excluiProduto($produtoId)
    {
        // Remove do modal de resumo E também da seleção principal
        unset($this->produtosEscolhidos[$produtoId]);
        unset($this->produtosSelecionados[$produtoId]);
        unset($this->valorUnitarios[$produtoId]);
        $this->produtosMarcados = array_filter($this->produtosMarcados, fn($id) => $id != $produtoId);
         // Zera a quantidade para este produto
         $this->quantidades[$produtoId] = 0;
        $this->inicializarValores(); // Recalcula totais
    }

    public function fecharModalResumoPedido()
    {
        $this->showModal = false;
    }

     public function finalizarPedido()
    {
        // Garante que a seleção final esteja correta
         $this->produtosEscolhidos = array_filter($this->produtosSelecionados, function($item) {
            // Garante que apenas itens com quantidade > 0 sejam considerados
            return isset($item['quantidade']) && $item['quantidade'] > 0 && isset($item['valor_total']) && $item['valor_total'] > 0;
         });

        if (empty($this->produtosEscolhidos)) {
            toastr('Selecione pelo menos um produto com quantidade válida.', 'error');
            return;
        }

        if ($this->metodoEntrega == 'entrega') {
            if (empty($this->numero) || empty($this->endereco)) {
                toastr('Adicione o endereço e o número de entrega', 'error');
                return;
            }
        }

        if (empty($this->metodoEntrega)) {
            toastr('Selecione o método de entrega', 'error');
            return;
        }

        // Recalcula os totais finais antes de salvar
         $this->valorTotal = array_sum(array_column($this->produtosEscolhidos, 'valor_total'));
        $this->aplicaDesconto();

        $numeroProdutosSelecionados = count($this->produtosEscolhidos);

        $pedido = new Pedidos();
        $pedido->cliente_id = $this->cliente->id;
        $pedido->razao_social = $this->cliente->razao_social;
        $pedido->cpf_cnpj = $this->cliente->numero_documento;
        $pedido->telefone = $this->cliente->telefone;
        $pedido->data = Carbon::now()->format('Y-m-d');
        $pedido->observacoes = $this->observacao;
        $pedido->numero_produtos = $numeroProdutosSelecionados;

        // --- Salvar os valores corretos ---
        $pedido->desconto = $this->desconto; // Salva a porcentagem
        $pedido->valor_original = $this->valorTotal; // Salva o valor antes do desconto
        $pedido->valor = $this->valorTotalComDesconto; // Salva o valor final com desconto
        // --- Fim da alteração dos valores ---

        $pedido->balcao = $this->metodoEntrega == 'balcao' ? 1 : 0;
        $pedido->endereco = $this->metodoEntrega == 'entrega' ? $this->endereco : null;
        $pedido->numero = $this->metodoEntrega == 'entrega' ? $this->numero : null;


        if (Auth::guard('vendedor')->check()) {
            $pedido->vendedor_id = Auth::guard('vendedor')->id();
        }

        $result = $pedido->save();

        if ($result) {
            $pedidoId = $pedido->id;

            foreach ($this->produtosEscolhidos as $value) {
                 // Pula itens que possam ter quantidade zerada no processo
                 if ($value['quantidade'] <= 0) continue;

                $pedidoItems = new PedidosItems();
                $pedidoItems->pedido_id = $pedidoId;
                $pedidoItems->produto_id = $value['id'];
                $pedidoItems->quantidade = $value['quantidade'];
                $pedidoItems->valor_unitario = $value['preco_unitario'];
                $pedidoItems->modelo = $value['modelo'];
                $pedidoItems->valor_total = $value['valor_total'];
                $resultPedidoItems = $pedidoItems->save();

                if ($resultPedidoItems) {
                    $produtos = Produtos::find($value['id']);
                    if ($produtos) { // Verifica se o produto ainda existe
                        $produtos->quantidade -= $value['quantidade'];
                        $produtos->save();

                        // --- Lógica de Movimentações (mantida como estava) ---
                        $movimentacoes = Movimentacoes::where('modelo', $produtos->modelo)
                            ->where('fornecedor', $produtos->fornecedor_id)
                            ->orderBy('id', 'desc') // Pega a última movimentação para ter o estoque mais recente
                            ->first();

                        $novaMovimentacao = new Movimentacoes();
                        $novaMovimentacao->referencia = $movimentacoes->referencia ?? bin2hex(random_bytes(6)); // Usa referência existente ou cria nova
                        $novaMovimentacao->modelo = $produtos->modelo;
                        $novaMovimentacao->compra = 0;
                        $novaMovimentacao->baixa = $value['quantidade'];
                         // Pega o estoque atualizado do produto após salvar
                        $novaMovimentacao->estoque = $produtos->quantidade;
                        // Mantém a data de reposição da última movimentação se existir
                        $novaMovimentacao->data_reposicao = $movimentacoes->data_reposicao ?? now();
                        $novaMovimentacao->data_baixa = now();
                        $novaMovimentacao->fornecedor = $produtos->fornecedor_id;
                         // Converte para float explicitamente
                        $novaMovimentacao->valor_unitario = (float) $value['preco_unitario'];
                        $novaMovimentacao->valor_total = (float) $value['valor_total'];
                        $novaMovimentacao->save();
                        // --- Fim da lógica de Movimentações ---
                    }
                }
            }

            toastr('Pedido Gerado com sucesso.', 'success');
            return redirect()->route('editar.pedido.get', $pedidoId);
        } else {
            toastr('Erro ao salvar o pedido.', 'error');
        }
    }

    // --- Funções restantes (excluirProdutoPedidoFeito, repetirPedido, etc.) mantidas como estavam ---
     public function excluirProdutoPedidoFeito($produtoId, $pedidoId)
    {
        $pedidoItem = PedidosItems::find($produtoId);

        if (!$pedidoItem) {
            toastr('Produto não encontrado.', 'error');
            return redirect('/novo-pedido');
        }

        $pedido = Pedidos::find($pedidoId);

        $produto = Produtos::find($pedidoItem->produto_id);

        if ($pedido) {
             // IMPORTANTE: Recalcular o valor original e o valor final do pedido
             $pedido->valor_original -= $pedidoItem->valor_total; // Subtrai do original

             // Recalcula o valor final com o desconto percentual original
             if ($pedido->desconto > 0 && $pedido->valor_original > 0) {
                 $descontoValor = $pedido->valor_original * ($pedido->desconto / 100);
                 $pedido->valor = $pedido->valor_original - $descontoValor;
             } else {
                 $pedido->valor = $pedido->valor_original; // Se não há desconto ou valor original, valor final = valor original
             }

             // Atualiza número de produtos
             $pedido->numero_produtos = PedidosItems::where('pedido_id', $pedidoId)->where('id', '!=', $produtoId)->count();


            if ($produto) {
                $produto->quantidade += $pedidoItem->quantidade;
                $produto->save();
            }

            $pedido->save();
        }

        $pedidoItem->delete();

        // Verifica se o pedido ficou sem itens após a exclusão
         $verificaPedidoPossuiItems = PedidosItems::where('pedido_id', $pedidoId)->exists();

        if (!$verificaPedidoPossuiItems && $pedido) { // Se não há mais itens E o pedido existe
            $pedido->delete();
            toastr('Produto excluído e pedido vazio removido.', 'success');
            return redirect('/pedidos'); // Redireciona para a lista geral
        }

        // Se ainda há itens, recarrega a página atual (ou a de edição)
         // Usando refresh para recarregar o estado do componente Livewire
         // ou redirecionando para a edição se for mais apropriado
         // return redirect()->route('editar.pedido.get', $pedidoId); // Se existir rota de edição
         return redirect(request()->header('Referer'))->with('success', 'Produto excluído com sucesso.'); // Recarrega a página anterior
    }
    public function repetirPedido($pedidoId)
    {
        $pedidoOriginal = Pedidos::with('items')->find($pedidoId); // Carrega itens junto

        if ($pedidoOriginal) {
            $novoPedido = $pedidoOriginal->replicate(['status', 'financeiro', 'confirmacao', 'data', 'vendedor_id']); // Copia campos relevantes, exclui outros
            $novoPedido->data = now();
            $novoPedido->status = 'nao pronto'; // Define status inicial padrão
            $novoPedido->financeiro = 'deve';   // Define financeiro inicial padrão
            $novoPedido->confirmacao = 'Ag Confirmacao'; // Define confirmação inicial padrão

             // Verifica estoque antes de duplicar (Opcional, mas recomendado)
            $estoqueSuficiente = true;
            foreach ($pedidoOriginal->items as $item) {
                $produto = Produtos::find($item->produto_id);
                if (!$produto || $produto->quantidade < $item->quantidade) {
                    $estoqueSuficiente = false;
                    toastr('Estoque insuficiente para o produto: '.$item->modelo.'. Pedido não duplicado.', 'error');
                    break;
                }
            }

            if (!$estoqueSuficiente) {
                 // Não faz nada se o estoque não for suficiente
                 return;
            }


            if (Auth::guard('vendedor')->check()) {
                $novoPedido->vendedor_id = Auth::guard('vendedor')->id();
            } else {
                 $novoPedido->vendedor_id = null; // Ou o ID de um vendedor padrão, se aplicável
            }
            $novoPedido->save(); // Salva o novo cabeçalho do pedido

            // Duplica os itens e atualiza o estoque
            foreach ($pedidoOriginal->items as $item) {
                $novoItem = $item->replicate();
                $novoItem->pedido_id = $novoPedido->id;
                $novoItem->save();

                 // Atualiza estoque do produto original
                 $produto = Produtos::find($item->produto_id);
                 if ($produto) {
                     $produto->quantidade -= $item->quantidade;
                     $produto->save();
                     // Opcional: Adicionar lógica de movimentação aqui também se necessário
                 }
            }

            // Adiciona o novo pedido à lista visível (se aplicável à sua UI)
            // $this->buscarPedidos(); // Recarrega a lista de pedidos do cliente atual
             toastr('Pedido duplicado com sucesso!', 'success');
             // Pode ser útil redirecionar para a edição do novo pedido
             return redirect()->route('editar.pedido.get', $novoPedido->id);


        } else {
             toastr('Pedido original não encontrado.', 'error');
        }
    }

    public function novoCliente()
    {
        session()->put(['telaPedidos' => 1]);
        return redirect('/cadastro-clientes');
    }

    public function buscarClientes()
    {
        if ($this->numero_documento == '' && $this->nomeCliente == '') {
            // Não mostra erro, apenas não busca se ambos estiverem vazios
            $this->clientes = []; // Limpa resultados anteriores
            return;
        }

        $query = Clientes::query();

        if (!empty($this->numero_documento)) {
            $query->where('numero_documento', 'like', '%' . $this->numero_documento . '%');
        }

        if (!empty($this->nomeCliente)) {
            $query->where('nome', 'like', '%' . $this->nomeCliente . '%');
        }

        $this->clientes = $query->limit(15)->get(); // Limita resultados para performance
    }

    public function selecionarCliente($clienteId)
    {
        $this->cliente = Clientes::find($clienteId);

        if ($this->cliente) {
            toastr('Cliente selecionado com sucesso!', 'success');
            $this->modalAberta = false; // Fechar a modal
        } else {
            toastr('Cliente não encontrado.', 'error');
        }
    }

}