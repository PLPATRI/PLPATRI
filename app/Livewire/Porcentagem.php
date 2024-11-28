<?php

namespace App\Livewire;

use App\Models\Fornecedores;
use App\Models\Produtos;
use Livewire\Component;

class Porcentagem extends Component
{
    public $fornecedor;
    public $fornecedor_id;
    public $produtos = [];
    public $produtoAlterado = [];
    public $produtosAlterados = [];
    public $selectAll = false;

    public $filtro_um = '';
    public $filtro_dois = '';

    public function mount()
    {
        $this->fornecedor = Fornecedores::all();
    }

    public function toggleSelectAll()
    {
        foreach ($this->produtos as $produto) {
            $this->produtoAlterado[$produto->id]['selecionado'] = $this->selectAll;
        }
    }

    public function pegarProdutos()
    {
        $this->produtos = Produtos::where('fornecedor_id', $this->fornecedor_id)->get();
    }

    public function filtroProdutos()
    {
        $query = Produtos::where('fornecedor_id', $this->fornecedor_id);

        if ($this->filtro_um != '') {
            $query->where('id', '>=', $this->filtro_um);
        }

        if ($this->filtro_dois != '') {
            $query->where('id', '<=', $this->filtro_dois);
        }
        $this->produtos = $query->get();
    }

    public function alterarProdutos()
    {
        $this->produtosAlterados = [];

        foreach ($this->produtoAlterado as $id => $data) {
            if (isset($data['selecionado']) && $data['selecionado'] && !empty($data['porcentagem'])) {
                $produto = Produtos::find($id);

                if ($produto) {
                    $this->produtosAlterados[] = [
                        'id_produto' => $produto->id,
                        'referencia' => $produto->referencia,
                        'modelo' => $produto->modelo,
                        'fornecedor' => $produto->fornecedor->razao_social,
                        'porcentagem' => $data['porcentagem'],
                        'valor_atualizado' => $produto->preco_unitario * (1 + $data['porcentagem'] / 100),
                    ];
                }
            }
        }
    }

    public function deleteProdutoAlterado($idProduto)
    {
        foreach ($this->produtosAlterados as $index => $alterado) {
            if ($alterado['íd_produto'] == $idProduto) {
                unset($this->produtosAlterados[$index]);
                break;
            }
        }

        $this->produtosAlterados = array_values($this->produtosAlterados);
    }

    public function salvar()
    {
        if ($this->produtosAlterados != []) {
            foreach ($this->produtosAlterados as $index => $alterado) {
                $produto = Produtos::find($alterado['íd_produto']);
                $produto->preco_unitario = $alterado['valor_atualizado'];
                $produto->save();
            }
            toastr('Produtos atualizados com sucesso!');
            redirect()->to('/porcentagem');
        }
        toastr('Nenhum produto adicionado!', 'error');
    }

    public function cancelarAlteracao()
    {
        unset($this->produtosAlterados);
        $this->produtosAlterados = array_values($this->produtosAlterados);
    }

    public function render()
    {
        return view('livewire.porcentagem', [
            'produtos' => $this->produtos,
            'produtosAlterados' => $this->produtosAlterados,
        ]);
    }
}
