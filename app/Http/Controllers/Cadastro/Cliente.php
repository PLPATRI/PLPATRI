<?php

namespace App\Http\Controllers\Cadastro;

use App\Http\Controllers\Controller;
use App\Models\Clientes;
use Illuminate\Http\Request;

class Cliente extends Controller
{
    public function index()
    {
        return view("cadastro/clientes");
    }

    public function post(Request $request)
    {
        if ($this->verificaCliente('email', $request->email)) {
            toastr('Já existe um cliente com esse email cadastrado', 'error');
            return redirect()->back();
        }

        if ($this->verificaCliente('numero_documento', $request->numero_documento)) {
            toastr('Já existe um cliente com esse documento cadastrado', 'error');
            return redirect()->back();
        }

        if ($this->verificaCliente('inscricao_estadual', $request->inscricao_estadual)) {
            toastr('Já existe um cliente com essa inscrição estadual cadastrada', 'error');
            return redirect()->back();
        }

        if ($this->verificaCliente('razao_social', $request->razao_social)) {
            toastr('Já existe um cliente com esse nome/razão social cadastrado', 'error');
            return redirect()->back();
        }
        $request->validate([
            'observacoes' => 'nullable|string|max:300', // Validação para o campo observações
        ]);

        if ($request->tipo_documento == "CPF") {
            $client = new Clientes([
                'nome' => $request->razao_social,
                'razao_social' => $request->razao_social,
                'email' => $request->email,
                'second_email' => $request->second_email,
                'cep' => $request->cep,
                'endereco' => $request->endereco,
                'bairro' => $request->bairro,
                'cidade' => $request->cidade,
                'uf' => $request->uf,
                'numero' => $request->numero,
                'telefone' => $request->telefone,
                'numero_documento' => $request->numero_documento,
                'tipo_documento' => $request->tipo_documento,
                'observacoes' => $request->observacoes,
            ]);
        }

        if ($request->tipo_documento == "CNPJ") {
            $client = new Clientes([
                'nome' => $request->razao_social,
                'email' => $request->email,
                'second_email' => $request->second_email,
                'telefone' => $request->telefone,
                'razao_social' => $request->razao_social,
                'inscricao_estadual' => $request->inscricao_estadual,
                'celular' => $request->celular,
                'cep' => $request->cep,
                'endereco' => $request->endereco,
                'bairro' => $request->bairro,
                'cidade' => $request->cidade,
                'uf' => $request->uf,
                'numero' => $request->numero,
                'numero_transportadora' => $request->numero_transportadora,
                'responsavel_transportadora' => $request->responsavel_transportadora,
                'tipo_documento' => $request->tipo_documento,
                'numero_documento' => $request->numero_documento,
                'transportadora' => $request->transportadora,
                'observacoes' => $request->observacoes,
            ]);
        }

        try {
            $client->save();
            $session = session()->get('telaPedidos');
            toastr('Cliente cadastrado com sucesso', 'success');
            if ($session == 1) {
                $redirect = redirect('novo-pedido');
                session()->put(['telaPedidos' => 0]);
                session()->put(['clientePedido' => $client]);
                return $redirect;
            }
        } catch (\Exception $e) {
            toastr('Não foi possível cadastrar o cliente: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }

        return redirect()->back();
    }

    public function verificaCliente($campo, $valor)
    {
        $verificacao = Clientes::where($campo, $valor)->first();

        if ($verificacao && $verificacao->inscricao_estadual !== null) {
            return true;
        }
        return false;
    }
}
