<?php

namespace App\Livewire\Estoque;

use Livewire\Component;
use App\Models\Fornecedores;
use App\Models\Produtos;
use Illuminate\Support\Facades\Session;

class CarregarEstoque extends Component
{

    public $id_fornecedor = '';
    public $fornecedores;
    public $produtosCarregamento = [];
    public $salvado = false;
    protected $rules = [
        'produtosCarregamento.*.data_carregamento' => 'required|date',
        'produtosCarregamento.*.preco_unitario' => 'required|numeric|min:0',
        'produtosCarregamento.*.quantidade' => 'required|numeric|min:0',
    ];

    public function salvarAgora()
    {
        $this->aplicar();
        $this->salvado = true;
    }

    public function aplicar()
    {

        $produtosAplicados = [];

        foreach ($this->produtosCarregamento as $id => $dataCarregamento) {
            $produtoSelecionado = Produtos::where('id', $id)->first();

            if (
                !empty($this->produtosCarregamento[$id]['data_carregamento']) &&
                !empty($this->produtosCarregamento[$id]['preco_unitario']) &&
                !empty($this->produtosCarregamento[$id]['quantidade'])
            ) {

                $produtosAplicados[] = [
                    'id' => $id,
                    'referencia' => $produtoSelecionado->referencia,
                    'data' => $produtoSelecionado->data,
                    'modelo' => $produtoSelecionado->modelo,
                    'data_carregamento' => $this->produtosCarregamento[$id]['data_carregamento'],
                    'preco_unitario' => $this->produtosCarregamento[$id]['preco_unitario'],
                    'quantidade' => $this->produtosCarregamento[$id]['quantidade'],
                ];
            }
        }

        if (!empty($produtosAplicados)) {
            Session::put('produtos_aplicados', $produtosAplicados);
            toastr('Confirme o registro dos produtos em estoque!', 'warning');
            $this->salvado = true;
        } else {
            toastr('Nenhum dado preenchido para salvar.', 'warning');
            $this->salvado = false;
        }
    }

    public function confirmarCadastro()
    {

        foreach ($this->produtosCarregamento as $id => $data) {
            if (
                !empty($this->produtosCarregamento[$id]['data_carregamento']) &&
                !empty($this->produtosCarregamento[$id]['preco_unitario']) &&
                !empty($this->produtosCarregamento[$id]['quantidade'])
            ) {
                $produto = Produtos::find($id);
                if ($produto) {
                    $produto->quantidade += $data['quantidade'];
                    $produto->preco_unitario = $data['preco_unitario'];
                    $produto->data = $data['data_carregamento'];
                    $produto->save();
                }
                Session::forget('produtos_aplicados');
                $this->salvado = false;
                toastr('Cadastro confirmado com sucesso!', 'success');
            }
            $this->salvado = false;
        }
    }

    public function mount()
    {
        $this->fornecedores = Fornecedores::all();
    }

    public function getFornecedor()
    {
        return Fornecedores::find($this->id_fornecedor);
    }

    public function getProdutosProperty()
    {
        return Produtos::where('fornecedor_id', $this->id_fornecedor)->get();
    }

    public function getCarregamentos()
    {
        return Session::get('produtos_aplicados', []);
    }

    public function deleteCarregamentos()
    {
        $this->salvado = false;
        return Session::forget('produtos_aplicados');
    }


    public function render()
    {
        return view('livewire.estoque.carregar-estoque', [
            'produtos' => $this->produtos,
            'fornecedores' => $this->fornecedores,
            'getFornecedor' => $this->getFornecedor(),
        ]);
    }
}
