<?php

namespace App\Http\Controllers\Cadastro;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Vendedores;

class Vendedor extends Controller
{
    public function index()
    {
        return view("cadastro/vendedores");
    }

    public function post(Request $request)
    {
        $vendedor = Vendedores::where('usuario', $request->usuario)->first();

        if ($vendedor) {
            toastr('Ja existe um vendedor cadastrado com esse usuario', type: 'error');
            return redirect()->back();
        }

        $vendedor = [
            'usuario' => $request->usuario,
            'senha' => password_hash($request->senha, PASSWORD_DEFAULT),
        ];

        $salvarVendedor = Vendedores::create($vendedor);

        if (!$salvarVendedor) {
            toastr('Erro ao salvar o vendedor', 'error');
            return redirect()->back();
        }
        toastr('Vendedor cadastrado com sucesso', 'success');
        return redirect()->back();
    }
}
