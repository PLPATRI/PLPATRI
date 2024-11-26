<?php

namespace App\Livewire\Pedidos;

use App\Models\Produtos;
use App\Models\PedidosItems;
use App\Models\Pedidos;
use App\Models\Movimentacoes;
use Livewire\Component;

class ModalEditarPedido extends Component
{
    public $produtos = [];
    public $pedido;
    public $referencia;
    public $modelo;
    public $fornecedor;
    public $selectedProdutos = [];
    public $quantidades = [];

    public function mount($pedido)
    {
        $this->pedido = $pedido;
        $this->updateProdutos();
    }

    public function render()
    {
        return view('livewire.pedidos.modal-editar-pedido', [
            "produtos" => $this->produtos,
        ]);
    }

    public function updatedReferencia()
    {
        $this->updateProdutos();
    }

    public function updatedModelo()
    {
        $this->updateProdutos();
    }

    public function updatedFornecedor()
    {
        $this->updateProdutos();
    }

    public function confirmar()
    {
        $pedido = Pedidos::find($this->pedido->id);
        foreach ($this->selectedProdutos as $produtoId) {
            $produto = Produtos::find($produtoId);
            $quantidade = $this->quantidades[$produtoId] ?? 0;

            if (!$produto) {
                toastr()->error('Produto não encontrado.');
                continue;
            }

            if ($quantidade <= 0) {
                toastr()->error('Quantidade inválida para o produto ' . $produto->referencia);
                continue;
            }

            // if ($produto->quantidade < $quantidade) {
            //     toastr()->error('Quantidade indisponível para o produto ' . $produto->referencia);
            //     continue;
            // }

            $newPedido = PedidosItems::create([
                'pedido_id' => $this->pedido->id,
                'produto_id' => $produto->id,
                'quantidade' => $quantidade,
                'valor_unitario' => $produto->preco_unitario,
                'modelo' => $produto->modelo,
                'valor_total' => $produto->preco_unitario * $quantidade,
            ]);

            $produto->quantidade -= $quantidade;
            $produto->save();

            $pedido->valor += $newPedido->valor_total;
            $pedido->save();

            $movimentacoes = Movimentacoes::where('modelo', $produto->modelo)->where('fornecedor', $produto->fornecedor_id)->first();
            $novaMovimentacao = new Movimentacoes();
            if (!$movimentacoes) {
                $novaMovimentacao->referencia = bin2hex(random_bytes(6));
                $novaMovimentacao->modelo = $produto->modelo;
                $novaMovimentacao->compra = $produto->quantidade;
                $novaMovimentacao->baixa = $produto['quantidade'];
                $novaMovimentacao->estoque = $produto->quantidade;
                $novaMovimentacao->data_reposicao = now();
                $novaMovimentacao->data_baixa = now();
                $novaMovimentacao->fornecedor =  $produto->fornecedor_id;
                $novaMovimentacao->valor_unitario = (float)$produto['preco_unitario'];
                $novaMovimentacao->valor_total = (float)$produto['preco_unitario'] * $produto['quantidade'];
                $novaMovimentacao->save();
            } else {
                $novaMovimentacao->referencia = $movimentacoes->referencia;
                $novaMovimentacao->modelo = $movimentacoes->modelo;
                $novaMovimentacao->compra = $produto['quantidade'];
                $novaMovimentacao->baixa = $produto['quantidade'];
                $novaMovimentacao->estoque = $produto->quantidade;
                $novaMovimentacao->data_reposicao = $movimentacoes->data_reposicao;
                $novaMovimentacao->data_baixa = now();
                $novaMovimentacao->fornecedor =  $produto->fornecedor_id;
                $novaMovimentacao->valor_unitario = (float)$produto['preco_unitario'];
                $novaMovimentacao->valor_total = (float)$produto['preco_unitario'] * $produto['quantidade'];
                $novaMovimentacao->save();
            }
            if ($movimentacoes) {
                $movimentacoes->save();
            }
        }

        toastr()->success('Produtos adicionados com sucesso.');
        $this->reset(['selectedProdutos', 'quantidades']);
        $this->updateProdutos();

        return redirect()->route('editar.pedido.get', $this->pedido->id)->with('success', 'Pedido atualizado com sucesso.');
    }

    private function updateProdutos()
    {
        $query = Produtos::query();

        if ($this->referencia) {
            $query->where('referencia', 'like', '%' . $this->referencia . '%');
        }

        if ($this->modelo) {
            $query->where('modelo', 'like', '%' . $this->modelo . '%');
        }

        if ($this->fornecedor) {
            $query->whereHas('fornecedor', function ($q) {
                $q->where('razao_social', 'like', '%' . $this->fornecedor . '%');
            });
        }

        $this->produtos = $query->take(10)->get();
    }
}
