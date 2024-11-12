<?php

namespace App\Livewire\Pedidos;

use App\Models\Clientes;
use App\Models\Fornecedores;
use App\Models\Movimentacoes;
use App\Models\Pedidos;
use App\Models\PedidosItems;
use App\Models\Produtos;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class NovoPedido extends Component
{
    public $numero_documento = '';
    public $nomeCliente = '';
    public $cliente;
    public $pedidos = [];
    public $produtos;
    public $quantidades = [];
    public $valorUnitarios = [];
    public $valorTotal = 0.00;
    public $valorTotalComDesconto = 0.00;

    public $desconto = 0.00;
    public $produtosSelecionados = [];

    public $referencia_inicial = 1;
    public $referencia_final = '';

    public $modelo = '';

    public $fornecedor = '';

    public $bloquear_input = [];

    public $produtosEscolhidos = [];

    public $showModal = false;
    public $showModalCliente = true;

    public $descontoAplicado = 0;

    public $metodoEntrega = '';
    public $endereco = '';
    public $numero = '';

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
    }

    public function updated()
    {
        $this->atualizarProdutos();
    }

    public function atualizarProdutos()
    {
        if ($this->referencia_inicial != '') {
            $query = Produtos::where('id', '>=', $this->referencia_inicial);
        }

        if ($this->referencia_final != '') {
            $query->where('id', '<=', $this->referencia_final);
        }


        if ($this->modelo != '') {
            $query->where('modelo', 'like', '%' . $this->modelo . '%');
        }


        if ($this->fornecedor != '') {
            $fornecedores = Fornecedores::where('razao_social', 'like', '%' . $this->fornecedor . '%')->first();
            if ($fornecedores) {
                $query->where('fornecedor_id', $fornecedores->id);
            }
        }

        $this->produtos = $query->get();
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
            $pedido = Pedidos::where('cliente_id', $this->cliente->id)->get();
            if ($pedido->count() > 0) {
                foreach ($pedido as $key => $value) {
                    $items = PedidosItems::where('pedido_id', $value['id'])->get()->toArray();

                    $this->pedidos[$value['id']] = [
                        'id' => $value['id'],
                        "quantidade" => $value['quantidade'],
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
                        'items' => []
                    ];

                    foreach ($items as $keyItems => $valueItems) {
                        $this->pedidos[$value['id']]['items'][] = [
                            "id" => $valueItems["id"],
                            "quantidade" => $valueItems["quantidade"],
                            "valor_unitario" => $valueItems["valor_unitario"],
                            "modelo" => $valueItems["modelo"],
                            "valor_total" => $valueItems["valor_total"],
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
        return view('livewire.pedidos.novo-pedido', ['pedidos' => $this->pedidos, 'cliente' => $this->cliente, 'produtos' => $this->produtos]);
    }

    public function calcula($quantidade, $valorUnitario, $produto_id)
    {
        $retorno = $valorUnitario * $quantidade;
        $produto = $this->produtos->find($produto_id);

        $this->produtosSelecionados[$produto_id] = [
            'id' => $produto->id,
            'produto_id' => $produto->id,
            'modelo' => $produto->modelo,
            'quantidade' => $quantidade,
            'preco_unitario' => $produto->preco_unitario,
            'valor_total' => $retorno
        ];

        $this->valorUnitarios[$produto_id] = $retorno;
        $this->valorTotal = array_sum($this->valorUnitarios);

        return $this->valorTotal;
    }

    public function toggleProduto($produtoId)
    {
        $produto = $this->produtos->find($produtoId);

        if ($produto === null) {
            return;
        }

        if (array_key_exists($produtoId, $this->produtosSelecionados)) {
            unset($this->produtosSelecionados[$produtoId]);
            unset($this->valorUnitarios[$produtoId]);
        } else {
            $quantidade = $this->quantidades[$produtoId] ?? 0;
            $preco_unitario = $produto->preco_unitario;


            $this->calcula($quantidade, $preco_unitario, $produtoId);
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
        $this->valorTotal = 0.00;
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

        if (Auth::guard('vendedor')->check()) {
            $pedido->vendedor_id = Auth::guard('vendedor')->id();
        }

        $result = $pedido->save();

        if ($result) {
            $pedidoId = $pedido->id;

            foreach ($this->produtosEscolhidos as $value) {
                $pedidoItems = new PedidosItems();
                $pedidoItems->pedido_id = $pedidoId;
                $pedidoItems->produto_id = $value['produto_id'];
                $pedidoItems->quantidade = $value['quantidade'];
                $pedidoItems->valor_unitario = $value['preco_unitario'];
                $pedidoItems->modelo = $value['modelo'];
                $pedidoItems->valor_total = $value['valor_total'];
                $resultPedidoItems = $pedidoItems->save();

                if ($resultPedidoItems) {
                    $produtos = Produtos::find($value['produto_id']);
                    $produtos->quantidade -= $value['quantidade'];
                    $produtos->save();

                    $movimentacoes = Movimentacoes::where('modelo', $produtos->modelo)->where('fornecedor', $produtos->fornecedor_id)->first();
                    $novaMovimentacao = new Movimentacoes();
                    if (!$movimentacoes) {
                        $novaMovimentacao->referencia = bin2hex(random_bytes(6));
                        $novaMovimentacao->modelo = $produtos->modelo;
                        $novaMovimentacao->compra = $produtos->quantidade;
                        $novaMovimentacao->baixa = $value['quantidade'];
                        $novaMovimentacao->estoque = $produtos->quantidade;
                        $novaMovimentacao->data_reposicao = now();
                        $novaMovimentacao->data_baixa = now();
                        $novaMovimentacao->fornecedor =  $produtos->fornecedor_id;
                        $novaMovimentacao->valor_unitario = (float)$value['preco_unitario'];
                        $novaMovimentacao->valor_total = (float)$value['preco_unitario'] * $value['quantidade'];
                        $novaMovimentacao->save();
                    } else {
                        $novaMovimentacao->referencia = $movimentacoes->referencia;
                        $novaMovimentacao->modelo = $movimentacoes->modelo;
                        $novaMovimentacao->compra = $value['quantidade'];
                        $novaMovimentacao->baixa = $value['quantidade'];
                        $novaMovimentacao->estoque = $produtos->quantidade;
                        $novaMovimentacao->data_reposicao = $movimentacoes->data_reposicao;
                        $novaMovimentacao->data_baixa = now();
                        $novaMovimentacao->fornecedor =  $produtos->fornecedor_id;
                        $novaMovimentacao->valor_unitario = (float)$value['preco_unitario'];
                        $novaMovimentacao->valor_total = (float)$value['preco_unitario'] * $value['quantidade'];
                        $novaMovimentacao->save();
                    }
                    if ($movimentacoes) {
                        $movimentacoes->save();
                    }
                }
            }

            toastr('Pedido Gerado com sucesso.', 'success');
            return redirect('/pedidos');
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
}
