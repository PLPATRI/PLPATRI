<div id="loader"></div>

<header class="main-header">
    <div class="inside-header">
        <div class="d-flex align-items-center logo-box justify-content-start">
            <!-- Logo -->
            <a href="" class="logo d-flex align-items-center">
                <!-- logo-->
                <img class="img-fluid" src="{{ asset('imgs/logo.jpg') }}" style="width: 100px">
                @if (Auth::guard('admin')->check())
                    <h4 class="logo-lg mb-0 text-dark">
                        - Admin
                    </h4>
                @else
                    <h4 class="logo-lg mb-0 text-dark">
                        - Vendedor
                    </h4>
                @endif

            </a>
        </div>
        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
        </nav>
    </div>
</header>
<style>
    .active_navbar {
        background: #3762EA !important;
        color: #ffffff !important;
    }
</style>

<nav class="main-nav" role="navigation">
    <!-- Sample menu definition -->
    <ul id="main-menu" class="sm sm-blue" data-smartmenus-id="17273103402347947">
        <li>
            @if (Auth::guard('admin')->check())
                <a class="{{ Request::is('dashboard') || Request::is('dashboard-vendedor') ? 'active_navbar ' : '' }}"
                    href="{{ route('dashboard.get') }}">
                    Dashboard
                </a>
            @else
            @endif

        </li>
        @if (Auth::guard('admin')->check())
            <li>
                <a class="{{ Request::is('estoque') || Request::is('carregar-estoque') ? 'active_navbar ' : '' }}"
                    href="{{ route('estoque.get') }}">Estoque</a>
            </li>
            <li>
                <a class="{{ Request::is('clientes') ? 'active_navbar ' : '' }}"
                    href="{{ route('clientes.get') }}">Clientes</a>
            </li>
            <li>
                <a href="#"
                    class="has-submenu {{ Request::is('cadastro-clientes') || Request::is('cadastro-fornecedores') || Request::is('cadastro-produtos') || Request::is('cadastro-vendedores') ? 'active_navbar' : '' }}"
                    id="sm-17273103402347947-1" aria-haspopup="true" aria-controls="sm-17273103402347947-2"
                    aria-expanded="false">
                    Cadastro
                    <i class="sub-arrow fa fa-angle-right"></i>
                </a>
                <ul id="sm-17273103402347947-2" role="group" aria-hidden="true"
                    aria-labelledby="sm-17273103402347947-1" aria-expanded="false">
                    <li>
                        <a class="{{ Request::is('cadastro-clientes') ? 'active_navbar' : '' }}"
                            href="{{ route('clientes.cadastrar.get') }}">Clientes</a>
                    </li>
                    <li>
                        <a class="{{ Request::is('cadastro-fornecedores') ? 'active_navbar' : '' }}"
                            href="{{ route('fornecedores.cadastrar.get') }}">Fornecedores</a>
                    </li>
                    <li>
                        <a class="{{ Request::is('cadastro-produtos') ? 'active_navbar' : '' }}"
                            href="{{ route('produtos.cadastrar.get') }}">Produtos</a>
                    </li>
                    <li>
                        <a class="{{ Request::is('cadastro-vendedores') ? 'active_navbar' : '' }}"
                            href="{{ route('vendedores.cadastrar.get') }}">Vendedores</a>
                    </li>
                </ul>

            </li>
            <li>
                <a href="{{ route('etiquetas.get') }}" class="{{ Request::is('etiquetas') ? 'active_navbar ' : '' }}">
                    Etiquetas
                </a>
            </li>
            <li>
                <a class="{{ Request::is('pedidos') ? 'active_navbar ' : '' }}" href="{{ route('pedidos.get') }}">
                    Pedidos
                </a>
            </li>
            <li><a class="{{ Request::is('movimentacoes') ? 'active_navbar ' : '' }}"
                    href="{{ route('movimentacoes.get') }}">Movimentações</a></li>
            <li>
                <a class="{{ Request::is('porcentagem') ? 'active_navbar ' : '' }}"
                    href="{{ route('porcentagem.get') }}">Porcentagem</a>
            </li>
            <li>
                <a class="{{ Request::is('configuracoes') ? 'active_navbar ' : '' }}"
                    href="{{ route('configuracoes.get') }}">Configurações</a>
            </li>
        @else
            <li>
                <a class="{{ Request::is('pedidos') ? 'active_navbar ' : '' }}" href="{{ route('pedidos.get') }}">
                    Pedidos
                </a>
            </li>
        @endif
        <li class="mt-1" style="border-radius: 8px !important;">
            <form action="{{ route('logout') }}" method="post" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" style="color: white; background-color: none !important;"
                    href="#">Sair</button>
            </form>
        </li>
    </ul>
</nav>
