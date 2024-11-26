<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuracoes;
use App\Models\Movimentacoes as MovimentacoesModel;
use App\Models\Fornecedores;


class Movimentacoes extends Controller
{
    public function index(Request $request)
    {
        $fornecedores = Fornecedores::all();

        $config = Configuracoes::first();
        $paginate = $config ? $config->numero_itens_tabelas : 10;

        $fornecedor_id = $request->input('fornecedor_id', '');
        $referenciaDe = $request->input('referencia_de');
        $referenciaAte = $request->input('referencia_ate');
        $modelo = $request->input('modelo');

        $query = MovimentacoesModel::query();

        if ($fornecedor_id != 'todos' && $fornecedor_id != '') {
            $query->where('fornecedor', $fornecedor_id);
        } else {
            $query->where('fornecedor', '!=', null);
        }

        // Aplicar filtros
        if ($referenciaDe) {
            $query->where('referencia', '>=', $referenciaDe);
        }

        if ($referenciaAte) {
            $query->where('referencia', '<=', $referenciaAte);
        }

        if ($modelo) {
            $query->where('modelo', 'like', '%' . $modelo . '%');
        }

        $query->orderBy('id', 'desc');

        // Paginação com os filtros anexados
        $produtos = $query->paginate($paginate)->appends($request->all());

        // Retornar os dados para a view
        return view('movimentacoes', compact(
            'fornecedores',
            'produtos',
            'fornecedor_id',
            'referenciaDe',
            'referenciaAte',
            'modelo'
        ));
    }
}
