<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Configuracoes;

class ConfiguracoesTabelas extends Component
{
    public int $quantidade = 10;

    public function mount()
    {
        $configuracoes = Configuracoes::first();
        if ($configuracoes) {
            $this->quantidade = $configuracoes->numero_itens_tabelas;
        }
    }

    public function alterTabela()
    {
        $configuracoes = Configuracoes::first();
        if (!$configuracoes) {
            $addConfig = new Configuracoes();
            $addConfig->numero_itens_tabelas = $this->quantidade;
            $addConfig->save();
        } else {
            $configuracoes->numero_itens_tabelas = $this->quantidade;
            $configuracoes->save();
        }
    }

    public function render()
    {
        return view('livewire.configuracoes-tabelas');
    }
}
