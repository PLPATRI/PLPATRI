<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\{
    Dashboard,
    LoginAdmin,
    Cliente,
    Configuracoes,
    DashboardVendedor,
    Etiquetas,
    Pedidos\Pedidos,
    Pedidos\NovoPedido,
    Estoque\CarregarEstoque,
    Estoque\Estoque,
    Movimentacoes,
    Porcentagem,
};

use App\Http\Controllers\Cadastro\{
    Cliente as ClienteCadastro,
    Fornecedor,
    Produto,
    Vendedor,
};

Route::get("/", [LoginAdmin::class, "index"])->name("login");
Route::post('/login-post', [LoginAdmin::class, 'login'])->name('login.post');


Route::middleware(['auth.admin'])->group(function () {
    Route::get('/dashboard', [Dashboard::class, 'index'])->name('dashboard.get');
    Route::get('/clientes', [Cliente::class, 'index'])->name('clientes.get');
    Route::get('/estoque', [Estoque::class, 'index'])->name('estoque.get');
    Route::get('/carregar-estoque', [CarregarEstoque::class, 'index'])->name('carregar.estoque.get');
    Route::get('/configuracoes', [Configuracoes::class, 'index'])->name('configuracoes.get');
    Route::get('/etiquetas', [Etiquetas::class, 'index'])->name('etiquetas.get');
    Route::get('/movimentacoes', [Movimentacoes::class, 'index'])->name('movimentacoes.get');
    Route::get('/porcentagem', [Porcentagem::class, 'index'])->name('porcentagem.get');

    //GET
    /*Route::get('/cadastro-clientes', [ClienteCadastro::class, 'index'])->name('clientes.cadastrar.get');*/
    Route::get('/cadastro-fornecedores', [Fornecedor::class, 'index'])->name('fornecedores.cadastrar.get');
    Route::get('/cadastro-produtos', [Produto::class, 'index'])->name('produtos.cadastrar.get');
    Route::get('/cadastro-vendedores', [Vendedor::class, 'index'])->name('vendedores.cadastrar.get');

    //POST
    Route::post('/clientes', [Cliente::class, 'index'])->name('clientes.filtrar');
    /*Route::post('/cadastrar-clientes', [ClienteCadastro::class, 'post'])->name('clientes.cadastrar.post');*/
    Route::post('/cadastrar-fornecedores', [Fornecedor::class, 'post'])->name('fornecedores.cadastrar.post');
    Route::post('/cadastrar-vendedores', [Vendedor::class, 'post'])->name('vendedores.cadastrar.post');
    Route::post('/cadastrar-produtos', [Produto::class, 'post'])->name('produtos.cadastrar.post');
    Route::post('/cadastrar-etiqueta', [Etiquetas::class, 'post'])->name('etiqueta.cadastrar.post');
    Route::post('/etiqueta-download', [Etiquetas::class, 'gerarPdf'])->name('etiqueta.download.post');

    //UPDATE
    Route::put('/alterar-cliente/{id}', [Cliente::class, 'edit'])->name('clientes.editar.post');
    Route::put('/editar-produto/{id}', [Estoque::class, 'editarProduto'])->name('produto.editar');
    Route::put('/alterar-valor-geral', [Estoque::class, 'alterarValorGeral'])->name('produtos.alterar.geral');
    Route::put('/alterar-valor-unitario', [Estoque::class, 'alterarValorUnitario'])->name('produtos.alterar.unitario');
    Route::put('/carregar-em-massa-sessao', [Estoque::class, 'carregarEmMassa'])->name('carregar.massa');
    Route::put('/alterar-vendedor', [Configuracoes::class, 'alterarVendedor'])->name('vendedores.put');

    //DELETE
    Route::delete('/deletar-cliente/{id}', [Cliente::class, 'delete'])->name('clientes.deletar.post');
    Route::delete('/deletar-produto/{id}', [Estoque::class, 'deletarProduto'])->name('produto.deletar');
    Route::delete('/logout', [LoginAdmin::class, 'logout'])->name('logout');
    Route::delete('/limpar-tabelas', [Configuracoes::class, 'deleteDataToTable'])->name('limpa.tabelas.deletar');
    Route::delete('/deletar-etiqueta', [Etiquetas::class, 'delete'])->name('etiqueta.delete');
});

Route::get('/cadastro-clientes', [ClienteCadastro::class, 'index'])->name('clientes.cadastrar.get');
Route::post('/cadastrar-clientes', [ClienteCadastro::class, 'post'])->name('clientes.cadastrar.post');
Route::get('/pedidos', [Pedidos::class, 'index'])->name('pedidos.get');
Route::get('/novo-pedido', [NovoPedido::class, 'index'])->name('novo.pedidos.get');

Route::middleware(['auth.vendedor'])->group(function () {
    Route::get('/dashboard-vendedor', [DashboardVendedor::class, 'index'])->name('dashboard.vendedor.get');
    //    Route::get('/pedidos', [Pedidos::class, 'index'])->name('pedidos.get');
    //    Route::get('/novo-pedido', [NovoPedido::class, 'index'])->name('novo.pedidos.get');

    Route::delete('/logout', [LoginAdmin::class, 'logout'])->name('logout');
});

Route::post('/gera-pdf-pedido', [Etiquetas::class, 'geraPdfPedido'])->name('pdf.pedido.post');
