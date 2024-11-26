<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Clientes;
use Illuminate\Support\Facades\Session;

use App\Models\Configuracoes;

class Cliente extends Controller
{


    public function index(Request $request)
    {

        if ($request->has('paginacao') && !is_null($request->paginacao)) {
            Session::put('paginacao', $request->paginacao);
        }
        $exibirTabela = Configuracoes::first();

        if (Session::get('paginacao')) {
            if (Session::get('paginacao') > 1) {
                $quantidade = Session::get('paginacao');
            } else {
                $quantidade = $exibirTabela->numero_itens_tabelas;
            }
        } else {
            if (empty($exibirTabela)) {
                $quantidade = 10;
            } else {
                $quantidade = $exibirTabela->numero_itens_tabelas;
            }
        }

        $query = Clientes::query();

        if ($request->nome != '' && $request->nome != null && $request->documento == '' && $request->documento == null) {
            $query->where('razao_social', 'like', '%' . $request->nome . '%');
        }

        if ($request->documento != '' && $request->documento != null && $request->nome == '' && $request->nome == null) {
            $query->where('numero_documento',  $request->documento);
        }

        if ($request->documento != '' && $request->nome !== '' && $request->documento != null && $request->nome !== null) {
            $query->where('razao_social', $request->nome)->where('numero_documento', $request->documento)->get()->toArray();
        }


        $clientes = $query->paginate($quantidade);

        return view("clientes", ['data' => $clientes]);
    }

    public function edit(Request $request, string $id)
    {
        $cliente = Clientes::find($id);

        if (!$cliente) {
            toastr('Nenhum cliente encontrado', 'error');
            return redirect()->back();
        }

        $cliente->update($request->only([
            'email',
            'second_email',
            'telefone',
            'razao_social',
            'inscricao_estadual',
            'celular',
            'cep',
            'endereco',
            'bairro',
            'cidade',
            'uf',
            'numero',
            'tipo_documento',
            'numero_documento',
            'transportadora',
            'responsavel_transportadora',
            'numero_transportadora',
            'observacoes'  
        ]));

        toastr('Cliente atualizado com sucesso', 'success');
        return redirect()->back();
    }

    public function delete(string $id)
    {
        $cliente = Clientes::find($id);

        $cliente->delete();

        toastr('Cliente atualizado com sucesso', 'success');
        return redirect()->back();
    }
}
