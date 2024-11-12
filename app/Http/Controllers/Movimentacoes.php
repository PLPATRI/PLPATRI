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
        $filtro_um = $request->input('filtro_um', null);
        $filtro_dois = $request->input('filtro_dois', null);

        $query = MovimentacoesModel::query();

        if ($fornecedor_id != 'todos' && $fornecedor_id != '') {
            $query->where('fornecedor', $fornecedor_id);
        } else {
            $query->where('fornecedor', '!=', null);
        }

        if (!is_null($filtro_um)) {
            $query->where('id', '>=', $filtro_um);
        }

        if (!is_null($filtro_dois)) {
            $query->where('id', '<=', $filtro_dois);
        }

        $query->orderBy('id', 'desc');

        $produtos = $query->paginate($paginate)->appends($request->all());

        return view('movimentacoes', compact(
            'fornecedores',
            'produtos',
            'fornecedor_id',
            'filtro_um',
            'filtro_dois',
        ));
    }
}
