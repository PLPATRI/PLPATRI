<?php

namespace App\Http\Controllers;

use App\Models\{
    Fornecedores,
    Vendedores,
    Clientes,
    Produtos,
    Pedidos
};

use Illuminate\Http\Request;

class Configuracoes extends Controller
{
    public function index()
    {
        $vendedores = Vendedores::all();
        $fornecedores = Fornecedores::all();
        return view('configuracoes', ['vendedores' => $vendedores, 'fornecedores' => $fornecedores]);
    }

    public function alterarVendedor(Request $request)
    {
        $verificaVendedor = Vendedores::where('usuario', $request->usuario)->first();
        if ($verificaVendedor) {
            toastr('Ja existe um vendedor cadastrado com esse mesmo nome', 'error');
            return redirect()->back();
        }

        $vendedor = Vendedores::where('id', $request->usuario_selecionado)->first();
        $vendedor->usuario = $request->usuario;
        $vendedor->senha = password_hash($request->senha, PASSWORD_DEFAULT);
        $result = $vendedor->save();
        if ($result) {
            toastr('Vendedor alterado com sucesso', 'success');
            return redirect()->back();
        }

        toastr('Houve um erro ao alterar os dados do vendedor', 'error');
        return redirect()->back();
    }

    public function deleteDataToTable(Request $request)
    {
       
        if ($request->vendedores == 'on') {
            // Verifica se há pedidos que fazem referência a vendedores
            $hasPedidos = Pedidos::whereNotNull('vendedor_id')->exists();

            if ($hasPedidos) {
                toastr('Não é possível excluir vendedores quando existem pedidos cadastrados', 'error');
                 return redirect()->back();
            }
        }

          if ($request->clientes == 'on') {
             Clientes::query()->delete();
        }

        if ($request->vendedores == 'on') {
              Vendedores::query()->delete();
        }

         if ($request->pedidos == 'on') {
             \App\Models\Pedidos::query()->delete();
        }

         if ($request->estoque == 'on') {
             if($request->fornecedor === 'todos'){
                Produtos::query()->delete();
             }else{
                Produtos::where('fornecedor_id', $request->fornecedor)->delete();
             }
        }

        toastr('Todos os dados das tabelas selecionadas foram removidos', 'success');
        return redirect()->back();
    }
}
