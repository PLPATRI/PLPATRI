<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    User,
    Vendedores,
};
use Illuminate\Support\Facades\Auth;

class LoginAdmin extends Controller
{

    public readonly User $user;
    public readonly Vendedores $vendedores;
    public function __construct(User $user, Vendedores $vendedores)
    {
        $this->user = $user;
        $this->vendedores = $vendedores;
    }
    public function index()
    {
        return view("login");
    }

    public function login(Request $request)
    {
        $request->validate([
            'tipo_login' => 'required|in:admin,vendedor',
            'senha' => 'required|string',
            'email' => 'nullable|string|email',
            'usuario' => 'nullable|string'
        ]);
    
        $request_tipo_login = $request->tipo_login == 'admin' ? 'email' : 'usuario';
        $credentials = $request->only($request_tipo_login, 'senha');
    
        if (empty($credentials[$request_tipo_login])) {
            toastr("Digite o email/usuario corretamente", 'warning', 'Aviso');
            return redirect()->route('login');
        }
    
        $usuario = null;
        $usuario_senha = '';
        switch ($request->tipo_login) {
            case 'admin':
                $usuario = $this->user::where('email', $credentials[$request_tipo_login])->first();
                if (!$usuario) {
                    toastr('usuario nao encontrado.', 'error', 'Erro');
                    return redirect()->back();
                }
                $usuario_senha = $usuario->password;
                break;
    
            case 'vendedor':
                $usuario = $this->vendedores::where('usuario', $credentials[$request_tipo_login])->first();
                if (!$usuario) {
                    toastr('usuario nao encontrado.', 'error', 'Erro');
                    return redirect()->back();
                }
                $usuario_senha = $usuario->senha;
                break;
        }
    
        if (!password_verify($credentials['senha'], $usuario_senha)) {
            toastr('Senha incorreta.', 'error', 'Erro');
            return redirect()->back();
        }
    
        if (!$usuario) {
            toastr('Usuário não encontrado.', 'error', 'Erro');
            return redirect()->back();
        }
    
        $guard = $request->tipo_login == 'admin' ? 'admin' : 'vendedor';
    
        if (password_verify($credentials['senha'], $usuario_senha)) {
            if ($guard == 'admin') {
                Auth::guard('admin')->login($usuario);
                return redirect()->route('dashboard.get'); // Admin redireciona para o dashboard do admin
            } else {
                Auth::guard('vendedor')->login($usuario);
                return redirect()->route('pedidos.get'); // Vendedor redireciona para a página de pedidos do vendedor
            }
        } else {
            toastr('Senha incorreta.', 'error', 'Erro');
            return redirect()->back();
        }
    
        toastr('Houve um erro ao tentar realizar o login', 'error', 'Erro');
        return redirect()->back();
    }
    
    


    public function logout(Request $request)
    {
        // Verifica qual guard está autenticado e faz logout
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }

        if (Auth::guard('vendedor')->check()) {
            Auth::guard('vendedor')->logout();
        }

        toastr('Você saiu com sucesso. Até logo!', 'success');

        return redirect()->route('login');
    }
}
