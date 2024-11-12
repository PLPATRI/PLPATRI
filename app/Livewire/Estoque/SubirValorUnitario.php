<?php

namespace App\Livewire\Estoque;

use Livewire\Component;
use App\Models\Fornecedores;
use App\Models\Produtos;

class SubirValorUnitario extends Component
{
    public $id_fornecedor = '';
    public $fornecedores;

    public function mount()
    {
        $this->fornecedores = Fornecedores::all();
    }

    public function getProdutosProperty()
    {
        return Produtos::where('fornecedor_id', $this->id_fornecedor)->get();
    }

    public function render()
    {
        return view('livewire.estoque.subir-valor-unitario', [
            'produtos' => $this->produtos,
            'fornecedores' => $this->fornecedores,
        ]);
    }
}
