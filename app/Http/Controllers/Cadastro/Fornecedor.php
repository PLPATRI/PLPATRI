<?php

namespace App\Http\Controllers\Cadastro;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Fornecedores;

class Fornecedor extends Controller
{
    public function index()
    {
        return view("cadastro/fornecedores");
    }

    public function post(Request $request)
    {
        $verificaFornecedor = Fornecedores::where('razao_social', $request->razao_social)->first();
        if ($verificaFornecedor) {
            toastr('Ja existe um fornecedor com essa razao social', 'error');
            return redirect()->back();
        }

        $fornecedores = new  Fornecedores([
            'razao_social' => $request->razao_social
        ]);
        try {
            $fornecedores->save();
            toastr('Fornecedor Cadastrado com sucesso', 'success');
            return redirect()->back();
        } catch (\Throwable $th) {
            toastr('Não foi possível cadastrar o fornecedor', 'error');
            return redirect()->back();
        }
    }
}
