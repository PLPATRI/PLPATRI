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
    public $valorTotal = 0.0;
    public $valorTotalComDesconto = 0.0;
    public $observacao = '';

    public $configuracoes;
    public $paginate;
    public $totalPaginate;

    public $desconto = 0.0;
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

    public $descontoAplicado = 0;

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
    }

    public function updated()
    {
        $this->atualizarProdutos();
    }

    public function atualizarProdutos()
    {
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
    
        $query->orderByRaw('CASE WHEN CAST(referencia AS UNSIGNED) > 0 THEN 0 ELSE 1 END, CAST(referencia AS UNSIGNED), referencia');

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
                        'valor' => $value['valor'],
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
        return view('livewire.pedidos.novo-pedido', [
            'pedidos' => $this->pedidos,
            'cliente' => $this->cliente,
            'clientes' => $this->clientes,
            'modalAberta' => $this->modalAberta,
            'produtos' => array_map(function ($produto) {
                $produto['quantidade'] = $this->quantidades[$produto['id']] ?? 0;
                $produto['valor_total'] = $this->valorUnitarios[$produto['id']] ?? 0;
                return $produto;
            }, $this->produtos['data']),
            'fornecedores' => $this->fornecedores,
        ]);
    }

    public function calcula($quantidade, $valorUnitario, $produto_id)
    {
        $this->quantidades[$produto_id] = $quantidade;
        $retorno = $valorUnitario * $quantidade;

        $produto = Produtos::find($produto_id);

        $this->produtosSelecionados[$produto_id] = [
            'id' => $produto_id,
            'quantidade' => $quantidade,
            'modelo' => $produto->modelo,
            'referencia' => $produto->referencia,
            'preco_unitario' => $valorUnitario,
            'valor_total' => $retorno,
        ];

        $this->valorUnitarios[$produto_id] = $retorno;
        $this->valorTotal = array_sum($this->valorUnitarios);

        return $this->valorTotal;
    }

    public function toggleProduto($produtoId)
    {
        if (in_array($produtoId, $this->produtosMarcados)) {
            $this->produtosMarcados = array_filter($this->produtosMarcados, function ($id) use ($produtoId) {
                return $id != $produtoId;
            });
            unset($this->produtosSelecionados[$produtoId]);
            unset($this->valorUnitarios[$produtoId]);
        } else {
            $this->produtosMarcados[] = $produtoId;
            $quantidade = $this->quantidades[$produtoId] ?? 0;
            $produto = Produtos::find($produtoId);
            if ($produto) {
                $this->calcula($quantidade, $produto->preco_unitario, $produtoId);
            }
        }
        $this->valorTotal = array_sum($this->valorUnitarios);
    }

    public function aplicaDesconto()
    {
        $this->valorTotalComDesconto = $this->valorTotal;

        if ($this->desconto > 0) {
            $descontoValor = $this->valorTotal * ($this->desconto / 100);
            $this->valorTotalComDesconto -= $descontoValor;
            $this->descontoAplicado = $this->desconto;
        }
    }
    public function gerarPedido()
    {
        if (empty($this->produtosSelecionados)) {
            toastr('Selecione os itens e a quantidade de cada item corretamente', 'error');
            return;
        }

        $this->produtosEscolhidos = $this->produtosSelecionados;
        $this->showModal = true;
    }

    public function limparCesta()
    {
        $this->produtosSelecionados = [];
        $this->valorTotal = 0.0;
        $this->quantidades = [];
        return redirect('/novo-pedido');
    }

    public function excluiProduto($produtoId)
    {
        unset($this->produtosEscolhidos[$produtoId]);
    }

    public function fecharModalResumoPedido()
    {
        $this->showModal = false;
    }

     public function finalizarPedido()
    {
        if (empty($this->produtosSelecionados)) {
            toastr('Selecione pelo menos um produto.', 'error');
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

        $numeroProdutosSelecionados = count($this->produtosSelecionados);

        $pedido = new Pedidos();
        $pedido->cliente_id = $this->cliente->id;
        $pedido->razao_social = $this->cliente->razao_social;
        $pedido->cpf_cnpj = $this->cliente->numero_documento;
        $pedido->desconto = $this->desconto;
        $pedido->valor = $this->valorTotal;
        $pedido->balcao = $this->metodoEntrega == 'balcao' ? 1 : 0;
        $pedido->endereco = $this->endereco;
        $pedido->numero = $this->numero;
        $pedido->telefone = $this->cliente->telefone;
        $pedido->data = Carbon::now()->format('Y-m-d');
        $pedido->observacoes = $this->observacao;
        $pedido->numero_produtos = $numeroProdutosSelecionados;


        if (Auth::guard('vendedor')->check()) {
            $pedido->vendedor_id = Auth::guard('vendedor')->id();
        }

        $result = $pedido->save();

        if ($result) {
            $pedidoId = $pedido->id;

            foreach ($this->produtosEscolhidos as $value) {
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
                    $produtos->quantidade -= $value['quantidade'];
                    $produtos->save();

                    $movimentacoes = Movimentacoes::where('modelo', $produtos->modelo)
                        ->where('fornecedor', $produtos->fornecedor_id)
                        ->first();
                    $novaMovimentacao = new Movimentacoes();
                    if (!$movimentacoes) {
                        $novaMovimentacao->referencia = bin2hex(random_bytes(6));
                        $novaMovimentacao->modelo = $produtos->modelo;
                        $novaMovimentacao->compra = 0;
                        $novaMovimentacao->baixa = $value['quantidade'];
                        $novaMovimentacao->estoque = $produtos->quantidade;
                        $novaMovimentacao->data_reposicao = now();
                        $novaMovimentacao->data_baixa = now();
                        $novaMovimentacao->fornecedor = $produtos->fornecedor_id;
                        $novaMovimentacao->valor_unitario = (float) $value['preco_unitario'];
                        $novaMovimentacao->valor_total = (float) $value['preco_unitario'] * $value['quantidade'];
                        $novaMovimentacao->save();
                    } else {
                        $novaMovimentacao->referencia = $movimentacoes->referencia;
                        $novaMovimentacao->modelo = $movimentacoes->modelo;
                        $novaMovimentacao->compra = 0;
                        $novaMovimentacao->baixa = $value['quantidade'];
                        $novaMovimentacao->estoque = $produtos->quantidade;
                        $novaMovimentacao->data_reposicao = $movimentacoes->data_reposicao;
                        $novaMovimentacao->data_baixa = now();
                        $novaMovimentacao->fornecedor = $produtos->fornecedor_id;
                        $novaMovimentacao->valor_unitario = (float) $value['preco_unitario'];
                        $novaMovimentacao->valor_total = (float) $value['preco_unitario'] * $value['quantidade'];
                        $novaMovimentacao->save();
                    }
                    if ($movimentacoes) {
                        $movimentacoes->save();
                    }
                }
            }

            toastr('Pedido Gerado com sucesso.', 'success');

            return redirect()->route('editar.pedido.get', $pedidoId);
            // return redirect('/pedidos');
        }
    }

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
            $pedido->valor -= $pedidoItem->valor_total;

            if ($produto) {
                $produto->quantidade += $pedidoItem->quantidade;
                $produto->save();
            }

            $pedido->save();
        }

        $pedidoItem->delete();

        $verificaPedidoPossuiItems = PedidosItems::where('pedido_id', $pedidoId)->exists();

        if (!$verificaPedidoPossuiItems) {
            $pedido->delete();
        }

        return redirect('/pedidos')->with('success', 'Produto excluído com sucesso.');
    }
    public function repetirPedido($pedidoId)
    {
        $pedidoOriginal = Pedidos::find($pedidoId);

        if ($pedidoOriginal) {
            $novoPedido = $pedidoOriginal->replicate();
            $novoPedido->data = now();
            $novoPedido->status = 'nao pronto';
            $novoPedido->financeiro = 'deve';
            $novoPedido->confirmacao = 'Ag Confirmacao';
            if (Auth::guard('vendedor')->check()) {
                $novoPedido->vendedor_id = Auth::guard('vendedor')->id();
            }
            $novoPedido->save();

            foreach ($pedidoOriginal->items as $item) {
                $novoItem = $item->replicate();
                $novoItem->pedido_id = $novoPedido->id;
                $novoItem->save();
            }

            $this->pedidos[] = $novoPedido;

            session()->flash('message', 'Pedido duplicado com sucesso!');
        } else {
            session()->flash('error', 'Pedido não encontrado.');
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
            toastr('Informe o número do documento ou o nome do cliente.', 'error');
            return;
        }

        $query = Clientes::query();

        if (!empty($this->numero_documento)) {
            $query->where('numero_documento', 'like', '%' . $this->numero_documento . '%');
        }

        if (!empty($this->nomeCliente)) {
            $query->where('nome', 'like', '%' . $this->nomeCliente . '%');
        }

        $this->clientes = $query->get();
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