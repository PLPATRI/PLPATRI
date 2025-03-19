<?php

namespace App\Http\Controllers\Estoque;

use App\Models\Fornecedores;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produtos;
use Illuminate\Support\Facades\Session;
use App\Models\Configuracoes;
use Illuminate\Support\Facades\DB;


class Estoque extends Controller
{
    public function index(Request $request)
    {
        // Captura dos filtros
        $modelo = $request->input('modelo');
        $fornecedor = $request->input('fornecedor');
        
        $produtos = Produtos::join('fornecedores', 'fornecedores.id', '=', 'produtos.fornecedor_id')
            ->leftJoin('movimentacoes', 'movimentacoes.referencia', '=', 'produtos.referencia')
            ->select(
                'produtos.*',
                'fornecedores.razao_social AS fornecedor',
                DB::raw('SUM(movimentacoes.compra) as total_compras'),
                DB::raw('SUM(movimentacoes.baixa) as total_baixas')
            )
            ->groupBy(
                'produtos.id',
                'produtos.referencia',
                'produtos.modelo',
                'produtos.fornecedor_id',
                'produtos.estoque_seguranca',
                'produtos.preco_unitario',
                'fornecedores.razao_social'
            );
    
        // Nova ordenação customizada para referência
        $produtos->orderByRaw('
            CAST(REGEXP_REPLACE(produtos.referencia, "[^0-9]", "") AS UNSIGNED),
            CASE 
                WHEN produtos.referencia REGEXP "[A-Z]" 
                THEN SUBSTRING(produtos.referencia, REGEXP_INSTR(produtos.referencia, "[A-Z]"))
                ELSE ""
            END ASC
        ');
        
        if ($modelo) {
            $produtos->where('produtos.modelo', 'like', '%' . $modelo . '%');
        }
    
        if ($fornecedor) {
            $produtos->where('fornecedores.id', $fornecedor);
        }
    
        // Paginação
        $numeroPaginate = Configuracoes::first();
        $paginas = $numeroPaginate ? $numeroPaginate->numero_itens_tabelas : 10;
    
        $paginate = $produtos->paginate($paginas);
    
        return view("estoque/estoque", [
            'data' => [
                'produtos' => $paginate->items(),
                'paginate' => $paginate,
                'fornecedores' => Fornecedores::all()
            ]
        ]);
    }



    public function editarProduto(Request $request, string $id)
    {
        $produto = Produtos::find($id);

        if (!$produto) {
            toastr('Nenhum produto encontrado', 'error');
            return redirect()->back();
        }

        $precoUnitario = str_replace(['R$', ' ', "\u{A0}", '.', ','], ['', '', '', '', '.'], $request->preco_unitario);

        if ((float)$precoUnitario > 99999999.99) {
            toastr('O preço unitário não pode ser maior que R$ 99.999.999,99', 'error');
            return redirect()->back();
        }

        $alterar = [
            'referencia' => $request->referencia,
            'modelo' => $request->modelo,
            'fornecedor_id' => $request->fornecedor_id,
            'data' => $request->data,
            'quantidade' => str_replace(['.', ','], ['', '.'], $request->quantidade),
            'preco_unitario' => (float)$precoUnitario,
            'estoque_seguranca' => $produto->estoque_seguranca
        ];

        $alterarProduto = Produtos::where('id', $id)->update($alterar);

        if (!$alterarProduto) {
            toastr('Não foi possível salvar o produto', 'error');
            return redirect()->back();
        }

        toastr('Produto atualizado com sucesso', 'success');
        return redirect()->back();
    }

    public function alterarValorGeral(Request $request)
    {

        if ($request->preco_unitario == '') {
            toastr('Adicione um valor', 'error');
        }
        $precoUnitario = str_replace(['R$', ' ', "\u{A0}", '.', ','], ['', '', '', '', '.'], $request->preco_unitario);

        if ((float)$precoUnitario > 99999999.99) {
            toastr('O preço unitário não pode ser maior que R$ 99.999.999,99', 'error');
            return redirect()->back();
        }

        $alterar = [
            'preco_unitario' => (float)$precoUnitario,
        ];

        $produto = Produtos::where('fornecedor_id', $request->fornecedor_id)->update($alterar);
        if (!$produto) {
            toastr('Nao foi possivel alterar os produtos desse fornecedor', 'error');
            return redirect()->back();
        }
        toastr('Produtos alterados com sucesso', 'success');
        return redirect()->back();
    }

    public function alterarValorUnitario(Request $request)
    {

        foreach ($request->all()['produto'] as $key => $valor) {
            if (isset($valor['check']) && $valor['check'] == 'on' && $valor['preco_unitario'] !== NULL) {
                $produto = Produtos::find($valor['id']);

                $precoUnitario = str_replace(['R$', ' ', "\u{A0}", '.', ','], ['', '', '', '', '.'], $valor['preco_unitario']);

                if ((float)$precoUnitario > 99999999.99) {
                    toastr("O preço unitário do produto $produto->referencia/$produto->modelo não pode ser maior que R$ 99.999.999,99", 'error');
                    return redirect()->back();
                }

                $dadosAtualizacao = [
                    'preco_unitario' => (float)$precoUnitario,
                ];

                $resultado = Produtos::where('id', $valor['id'])->update($dadosAtualizacao);
                if (!$resultado) {
                    toastr("Não foi possível alterar o produto $produto->referencia/$produto->modelo ", 'error');
                } else {
                    toastr("Produto $produto->referencia/$produto->modelo  alterado com sucesso", 'success');
                }
            }
        }
        return redirect()->back();
    }

    public function carregarEmMassa(Request $request)
    {
        $data = [
            'data_carregamento' => $request->input('data_carregamento'),
            'preco_unitario' => $request->input('preco_unitario'),
            'quantidade' => $request->input('quantidade'),
            'referencia' => $request->input('referencia', []), // Incluindo referência
            'modelo' => $request->input('modelo', []), // Incluindo modelo
        ];
        Session::put('produtos_aplicados', $data);

        return redirect()->back()->with('success', 'Dados aplicados com sucesso!');
    }


    public function deletarProduto($id)
    {
        Produtos::find($id)->delete();
        toastr('Produto deletado com sucesso', 'success');
        return redirect()->back();
    }
}
