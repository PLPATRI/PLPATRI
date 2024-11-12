<?php

namespace App\Http\Controllers\Cadastro;

use App\Http\Controllers\Controller;

use App\Models\Movimentacoes;
use Illuminate\Http\Request;
use App\Models\Fornecedores;
use App\Models\Produtos;

class Produto extends Controller
{
    public function index()
    {
        $fornecedores = Fornecedores::all();
        return view("cadastro/produtos", ['data' => $fornecedores]);
    }

    public function post(Request $request)
    {
        $precoUnitario = str_replace(['R$', ' ', "\u{A0}", '.', ','], ['', '', '', '', '.'], $request->preco_unitario);

        if (!is_numeric($precoUnitario)) {
            toastr('O preço unitário deve ser um número válido', 'error');
            return redirect()->back();
        }

        if ((float)$precoUnitario > 99999999.9999) {
            toastr('O preço unitário não pode ser maior que R$ 99.999.999,9999', 'error');
            return redirect()->back();
        }

        $salvar = [
            'referencia' => $request->referencia,
            'modelo' => $request->modelo,
            'fornecedor_id' => $request->fornecedor_id,
            'data' => $request->data,
            'quantidade' => $request->quantidade,
            'preco_unitario' => (float)$precoUnitario,
            'estoque_seguranca' => $request->estoque_seguranca
        ];

        $salvarProduto = Produtos::create($salvar);
        if (!$salvarProduto) {
            toastr('Não foi possível salvar o produto', 'error');
            return redirect()->back();
        }

        $movimentacoes = new Movimentacoes();
        $movimentacoes->referencia = $request->referencia;
        $movimentacoes->modelo  = $request->modelo;
        $movimentacoes->compra = $request->quantidade;
        $movimentacoes->baixa = 0;
        $movimentacoes->estoque = $request->quantidade;
        $movimentacoes->data_reposicao = now();
        $movimentacoes->data_baixa = now();
        $movimentacoes->fornecedor = $request->fornecedor_id;
        $movimentacoes->valor_unitario = (float)$precoUnitario;
        $movimentacoes->valor_total = (float)$precoUnitario * $request->quantidade;
        $movimentacoes->save();

        toastr('Produto cadastrado com sucesso', 'success');
        return redirect()->back();
    }
}
