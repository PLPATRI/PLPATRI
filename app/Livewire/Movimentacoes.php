<?php

namespace App\Livewire;

use App\Http\Controllers\Cadastro\Fornecedor;
use App\Models\Produtos;
use App\Models\Configuracoes;
use Livewire\Component;
use App\Models\Fornecedores;
use App\Models\Movimentacoes as movimentacoesModel;

class Movimentacoes extends Component
{

    public $fornecedores;
    public $fornecedor_id = '';
    public $produtos = [];

    public $filtro_um = '';
    public $filtro_dois = '';
    public $paginate;

    public function mount()
    {
        // aqui pegar o campo numero_itens_tabelas da tabela configuracoes
        $config = Configuracoes::first();
        $this->paginate = $config ? $config->numero_itens_tabelas : 10;
        $this->fornecedores = Fornecedores::get()->toArray();
    }

    public function mostrarProdutosFornecedores()
    {
        if ($this->fornecedor_id) {
            $this->produtos = movimentacoesModel::where('fornecedor', $this->fornecedor_id)->paginate($this->pagi)->toArray();
        } else {
            $this->produtos = [];
        }
    }
    public function filtroMovimentacoes()
    {
        $query = movimentacoesModel::where('fornecedor', $this->fornecedor_id);

        if ($this->filtro_um != '') {
            $query->where('id', '>=', $this->filtro_um);
        }

        if ($this->filtro_dois != '') {
            $query->where('id', '<=', $this->filtro_dois);
        }
        $this->produtos = $query->get();
    }

    public function render()
    {
        return view('livewire.movimentacoes', ['produtos' => $this->produtos]);
    }
}
