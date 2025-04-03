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
    RelatorioController
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
    Route::get('/porcentagem', [Porcentagem::class, 'index'])->name('porcentagem.get');
    Route::get('/configuracoes', [Configuracoes::class, 'index'])->name('configuracoes.get');
    Route::put('/alterar-vendedor', [Configuracoes::class, 'alterarVendedor'])->name('vendedores.put');
Route::get('/etiquetas', [Etiquetas::class, 'index'])->name('etiquetas.get');
    //DELETE
    Route::delete('/deletar-cliente/{id}', [Cliente::class, 'delete'])->name('clientes.deletar.post');
    Route::delete('/deletar-produto/{id}', [Estoque::class, 'deletarProduto'])->name('produto.deletar');
    Route::delete('/logout', [LoginAdmin::class, 'logout'])->name('logout');
    Route::delete('/limpar-tabelas', [Configuracoes::class, 'deleteDataToTable'])->name('limpa.tabelas.deletar');
});

Route::get('/cadastro-clientes', [ClienteCadastro::class, 'index'])->name('clientes.cadastrar.get');
Route::post('/cadastrar-clientes', [ClienteCadastro::class, 'post'])->name('clientes.cadastrar.post');
Route::get('/pedidos', [Pedidos::class, 'index'])->name('pedidos.get');
Route::get('/novo-pedido', [NovoPedido::class, 'index'])->name('novo.pedidos.get');
Route::get('/clientes', [Cliente::class, 'index'])->name('clientes.get');
Route::get('/estoque', [Estoque::class, 'index'])->name('estoque.get');
Route::get('/carregar-estoque', [CarregarEstoque::class, 'index'])->name('carregar.estoque.get');
Route::get('/movimentacoes', [Movimentacoes::class, 'index'])->name('movimentacoes.get');
Route::get('/cadastro-fornecedores', [Fornecedor::class, 'index'])->name('fornecedores.cadastrar.get');
Route::get('/cadastro-produtos', [Produto::class, 'index'])->name('produtos.cadastrar.get');
Route::get('/cadastro-vendedores', [Vendedor::class, 'index'])->name('vendedores.cadastrar.get');
//UPDATE
Route::put('/alterar-cliente/{id}', [Cliente::class, 'edit'])->name('clientes.editar.post');
Route::put('/editar-produto/{id}', [Estoque::class, 'editarProduto'])->name('produto.editar');
Route::put('/alterar-valor-geral', [Estoque::class, 'alterarValorGeral'])->name('produtos.alterar.geral');
Route::put('/alterar-valor-unitario', [Estoque::class, 'alterarValorUnitario'])->name('produtos.alterar.unitario');
Route::put('/carregar-em-massa-sessao', [Estoque::class, 'carregarEmMassa'])->name('carregar.massa');

//POST
Route::post('/clientes', [Cliente::class, 'index'])->name('clientes.filtrar');
Route::post('/cadastrar-fornecedores', [Fornecedor::class, 'post'])->name('fornecedores.cadastrar.post');
Route::post('/cadastrar-vendedores', [Vendedor::class, 'post'])->name('vendedores.cadastrar.post');
Route::post('/cadastrar-produtos', [Produto::class, 'post'])->name('produtos.cadastrar.post');
Route::delete('/deletar-cliente/{id}', [Cliente::class, 'delete'])->name('clientes.deletar.post');
Route::delete('/deletar-produto/{id}', [Estoque::class, 'deletarProduto'])->name('produto.deletar');


Route::middleware(['auth.vendedor'])->group(function () {
    Route::get('/dashboard-vendedor', [DashboardVendedor::class, 'index'])->name('dashboard.vendedor.get');
    Route::delete('/logout', [LoginAdmin::class, 'logout'])->name('logout');
});
Route::get('editar-pedido/{id}', [Pedidos::class, 'editarPedido'])->name('editar.pedido.get');

Route::post('/excluir-pedido', [Pedidos::class, 'excluirPedido'])->name('pedido.delete');

Route::post('/excluir-pedido-item', [Pedidos::class, 'excluirItemPedido'])->name('pedido.item.delete');

Route::post('/validar-pedido', [Pedidos::class, 'validarPedido'])->name('pedido.validar');

Route::post('/atualizar-pedido', [Pedidos::class, 'atualizarStatus'])->name('pedido.update');

Route::post('/atualizar-pedido-financeiro', [Pedidos::class, 'atualizarFinanceiro'])->name('pedido.financeiro');

Route::get('/produtos/paginados', [Pedidos::class, 'getProdutosPaginados'])->name('produtos.paginados');

Route::get('/filtrar-produtos', [Produto::class, 'filtrarProdutos']);

Route::post('/gera-pdf-pedido', [Etiquetas::class, 'geraPdfPedido'])->name('pdf.pedido.post');

Route::get('/relatorio-vendedores', [RelatorioController::class, 'vendedores'])->name('relatorio.vendedores.get');
Route::get('/relatorio-curva', [RelatorioController::class, 'curva'])->name('relatorio.curva.get');
Route::get('/relatorio-funil', [RelatorioController::class, 'funil'])->name('relatorio.funil.get');

Route::post('/pedidos/{pedidoId}/salvar-observacao', [Pedidos::class, 'salvarObservacao'])->name('pedido.salvar.observacao');
Route::post('/pedidos/{pedidoId}/salvar-desconto', [Pedidos::class, 'salvarDesconto'])->name('pedido.salvar.desconto');
Route::post('/pedidos/validar', [Pedidos::class, 'validarPedido'])->name('pedido.validar');
Route::post('/pedidos/item/{itemId}/quantidade', [Pedidos::class, 'atualizarQuantidade'])->name('pedido.item.quantidade.update');
