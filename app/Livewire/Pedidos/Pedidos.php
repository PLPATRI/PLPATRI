<?php

namespace App\Livewire\Pedidos;

use App\Models\Configuracoes;
use App\Models\Pedidos as  ModelsPedidos;
use App\Models\PedidosItems;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;


class Pedidos extends Component
{
    public $numero_pedido_incial = '';
    public $numero_pedido_final = '';
    public $razao_social = '';

    public $numero_documento;

    public $data_inicial;
    public $data_final;

    public $pedidoSelecionado;

    public $observacao;
    public $valorPedido = [];

    public $descontoPedido = [];

    public $alterarPedidoSelecionadoItems = [];

    public $cliente;

    public $vendedor = null;

    public $loading = false;

    public function mount()
    {
        $this->data_inicial = '';
        $this->data_final = '';
    }

    public function editarPedido($pedidoId)
    {
        $this->loading = true;

        $pedido = ModelsPedidos::find($pedidoId);
        $this->cliente = $pedido->cliente;
        if ($pedido->vendedor_id !== null) {
            $this->vendedor = $pedido->vendedor;
        } else {
            $this->vendedor = null;
        }
        $this->pedidoSelecionado = $pedido;

        $this->loading = false;
    }

    public function render()
    {
        $numeroPaginate = Configuracoes::first();
        if (empty($numeroPaginate)) {
            $paginas = 10;
        } else {
            $paginas = $numeroPaginate->numero_itens_tabelas;
        }

        $pedidosQuery = ModelsPedidos::query();


        if (!empty($this->razao_social)) {
            $pedidosQuery->where('razao_social', 'like', '%' . $this->razao_social . '%');
        }

        if (!empty($this->numero_documento)) {
            $pedidosQuery->where('cpf_cnpj', 'like', '%' . $this->numero_documento . '%');
        }

        if (!empty($this->data_inicial)) {
            $pedidosQuery->where('data', '>=', $this->data_inicial);
        }

        if (!empty($this->data_final)) {
            $pedidosQuery->where('data', '<=', $this->data_final);
        }

        if ($this->numero_pedido_incial > 0) {
            $pedidosQuery->where('id', '>=', $this->numero_pedido_incial);
        }

        if ($this->numero_pedido_final > 0) {
            $pedidosQuery->where('id', '<=', $this->numero_pedido_final);
        }

        $pedidos = $pedidosQuery->paginate($paginas);

        foreach ($pedidos as $pedido) {
            $this->observacao[$pedido->id] = $pedido->observacoes;
        }

        return view('livewire.pedidos.pedidos', ['pedidos' => $pedidos, 'pedidoSelecionado' => $this->pedidoSelecionado]);
    }

    public function ajustarValor($pedidoId)
    {
        $pedido = ModelsPedidos::find($pedidoId);

        if ($pedido) {
            $pedido->valor = $this->valorPedido[$pedidoId];
            $pedido->save();
        }

        $this->pedidoSelecionado = $pedido;
    }

    public function aplicarDesconto($pedidoId)
    {
        $pedido = ModelsPedidos::find($pedidoId);

        if ($pedido) {
            $desconto = $this->descontoPedido[$pedidoId];
            $valorOriginal = $pedido->valor;

            $valorDesconto = ($desconto / 100) * $valorOriginal;
            $pedido->valor = $valorOriginal - $valorDesconto;

            $pedido->desconto = $desconto;
            $pedido->save();
        }

        $this->pedidoSelecionado = $pedido;
    }


    public function excluirPedido($pedidoId)
    {
        $pedido = ModelsPedidos::find($pedidoId);
        PedidosItems::where('pedido_id')->delete();
        $pedido->delete();

        return redirect()->to('/pedidos');
    }

    public function deletarItemPedido($itemId, $pedidoId, $valorDoItem)
    {
        $item = PedidosItems::find($itemId);
        if ($item) {
            $item->delete();
        }

        $pedidoItemsCount = PedidosItems::where('pedido_id', $pedidoId)->count();

        if ($pedidoItemsCount === 0) {
            $pedido = ModelsPedidos::find($pedidoId);
            if ($pedido) {
                $pedido->delete();
                return redirect()->to('/pedidos');
            }
        }

        $pedido = ModelsPedidos::find($pedidoId);
        if ($pedido) {
            $valorTotal = $pedido->items->sum('valor_total');
            $pedido->valor = $valorTotal;
            $pedido->save();

            $this->pedidoSelecionado = $pedido;
        }
    }


    public function addObservacoes($pedidoId)
    {
        $pedido = ModelsPedidos::find($pedidoId);
        $pedido->observacoes = $this->observacao[$pedidoId];
        $pedido->save();

        $this->pedidoSelecionado = $pedido;
    }

    public function pedidoPronto($pedidoId)
    {
        $pedido = ModelsPedidos::find($pedidoId);
        $pedido->status = 'pronto';
        $pedido->save();

        return redirect()->to('/pedidos');
    }

    public function pedidoPago($pedidoId)
    {
        $pedido = ModelsPedidos::find($pedidoId);
        $pedido->financeiro = 'pago';
        $pedido->save();

        return redirect()->to('/pedidos');
    }

    public function validarPedido($pedidoId)
    {
        $pedido = ModelsPedidos::find($pedidoId);
        $pedido->confirmacao = 'Confirmado';
        $pedido->save();

        return redirect()->to('/pedidos');
    }

    public function salvarAlteracoes()
    {
        if ($this->pedidoSelecionado) {
            foreach ($this->pedidoSelecionado->items as $item) {
                if (isset($this->alterarPedidoSelecionadoItems[$item->id])) {
                    $pedidoItem = $item;

                    $pedidoItem->quantidade = $this->alterarPedidoSelecionadoItems[$item->id];
                    $pedidoItem->valor_total = $pedidoItem->valor_unitario * $pedidoItem->quantidade;

                    $pedidoItem->save();
                }
            }

            $valorTotal = $this->pedidoSelecionado->items->sum('valor_total');
            $pedido = $this->pedidoSelecionado;
            $pedido->valor = $valorTotal;
            $pedido->save();

            $this->pedidoSelecionado->refresh();
        }
    }
}
