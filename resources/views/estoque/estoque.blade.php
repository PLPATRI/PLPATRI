@section('title', 'Estoque - Combrim')

@extends('components.main')
@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Main content -->
            <section class="">
                <div class="row">
                    <div class="col-xxl-12">
                        <div class="box">
                            <div class="box-header with-border my-15">
                                <h3 class="box-title mb-5">Todos os produtos</h3>
                                <div class="d-flex justify-content-between align-items-center">
                                    <form method="GET" action="{{ route('estoque.get') }}" class="d-flex align-items-center">
                                        <div class="form-group d-flex mb-0 me-20 align-items-end">
                                            <div>
                                                <label for="">Modelo</label>
                                                <input type="text" class="form-control "
                                                    name="modelo" value="{{ request('modelo') }}">
                                            </div>
                                            <button type="submit" class="btn btn-sm btn-primary ms-2">
                                                <i class="fas fa-search"></i> 
                                            </button>    
                                        </div>
                                    
                                        <div class="form-group mb-0">
                                            <label>Selecione um fornecedor</label>
                                            <select class="form-control" name="fornecedor" onchange="this.form.submit()">
                                                <option value="">Selecione um Fornecedor</option>
                                                @foreach ($data['fornecedores'] as $fornecedor)
                                                    <option value="{{ $fornecedor['id'] }}"
                                                            {{ request('fornecedor') == $fornecedor['id'] ? 'selected' : '' }}>
                                                        {{ $fornecedor['razao_social'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </form>
                                    <div class="d-flex" style="gap: 15px">
                                        <a href="{{ route('carregar.estoque.get') }}" class="btn btn-primary">
                                            Carregar Estoque
                                        </a>
                                        <a data-bs-toggle="modal" data-bs-target=".value-product-modal"
                                            class="btn btn-primary-light">
                                            Alterar valor unitário
                                        </a>
                                        <a data-bs-toggle="modal" data-bs-target=".value-product-geral-modal"
                                            class="btn btn-primary-light">
                                            Alterar valor geral
                                        </a>
                                        <a href="{{ route('produtos.cadastrar.get') }}" class="btn btn-primary-light">
                                            Adicionar Produto
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                {{-- <th></th> --}}
                                                <th>Referência</th>
                                                <th>Modelo</th>
                                                <th>Fornecedor</th>
                                                <th>Movimentação</th>
                                                <th>Compra</th>
                                                <th>Venda</th>
                                                <th>Estoque de segurança</th>
                                                <th>Valor Unitário</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($data['paginate'] as $produto)
                                                <tr>
                                                    {{-- <td class="d-flex justify-content-center">
                                                        <input type="checkbox" id="basic_checkbox_1"
                                                            name="produto_selecionado" value="{{ $produto['id'] }}"
                                                            class="filled-in">
                                                        <label for="basic_checkbox_1"></label>
                                                    </td> --}}
                                                    <td>{{ $produto['referencia'] }}</td>
                                                    <td>{{ $produto['modelo'] }}</td>
                                                    <td>{{ $produto['fornecedor'] }}</td>
                                                    @if ($produto['quantidade'] <= $produto['estoque_seguranca'])
                                                        <td style="color:rgb(255, 0, 0);"><i class="fas fa-warning"
                                                                style="margin-right: 10px;"></i><b>{{ number_format($produto['quantidade'], 0, '', '.') }}</b>
                                                        </td>
                                                    @else
                                                        <td style="color:green"><i class="fas fa-check"
                                                                style="margin-right: 10px;"></i><b>{{ number_format($produto['quantidade'], 0, '', '.') }}</b>
                                                        </td>
                                                    @endif
                                                    <td>{{ number_format($produto->total_compras, 0, '.', '.') }}</td>
                                                    <td>{{ number_format($produto->total_baixas, 0, '.', '.') }}</td>
                                                    <td>{{ number_format($produto['estoque_seguranca'], 0, '', '.') }}</td>
                                                    <td>R$ {{ number_format($produto['preco_unitario'], 4, ',', '.') }}
                                                    </td>
                                                    <td class="d-flex justify-content-center" style="gap: 15px">
                                                        <i data-bs-toggle="modal"
                                                            data-bs-target=".view-product-modal_{{ $produto['id'] }}"
                                                            style="line-height: 1.7;font-size: 20px; cursor: pointer"
                                                            class="fas fa-eye"></i>
                                                        <i data-bs-toggle="modal"
                                                            data-bs-target=".edit-product-modal_{{ $produto['id'] }}"
                                                            style="line-height: 1.7;font-size: 20px; cursor: pointer"
                                                            class="fas fa-edit"></i>
                                                        <i data-bs-toggle="modal"
                                                            data-bs-target=".trash-product-modal_{{ $produto['id'] }}"
                                                            style="line-height: 1.7;font-size: 20px; cursor: pointer"
                                                            class="fas fa-trash"></i>
                                                    </td>
                                                </tr>

                                                <!-- VER PRODUT0 -->
                                                <div class="modal fade view-product-modal_{{ $produto['id'] }}"
                                                    tabindex="-1" role="dialog" aria-labelledby="viewProductModal"
                                                    aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myLargeModalLabel">Visualizar
                                                                    produto - {{ $produto['modelo'] }}</h4>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row justify-content-center">
                                                                    <div class="col-12">
                                                                        <div class="box">
                                                                            <!-- /.box-header -->
                                                                            <form class="form" action="">
                                                                                <div class="box-body">
                                                                                    <hr class="my-15">
                                                                                    <div class="row">
                                                                                        <div class="col-md-3">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    class="form-label">Referência</label>
                                                                                                <input type="text"
                                                                                                    disabled
                                                                                                    class="form-control"
                                                                                                    value="{{ $produto['referencia'] }}">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-9">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    class="form-label">Modelo</label>
                                                                                                <input type="text"
                                                                                                    disabled
                                                                                                    class="form-control"
                                                                                                    value="{{ $produto['modelo'] }}">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-6">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    class="form-label">Fornecedor</label>
                                                                                                <input type="text"
                                                                                                    disabled
                                                                                                    class="form-control"
                                                                                                    value="{{ $produto['fornecedor'] }}">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    class="form-label">Preço
                                                                                                    unitário</label>
                                                                                                <input type="text"
                                                                                                    disabled
                                                                                                    class="form-control"
                                                                                                    value="R$ {{ number_format($produto['preco_unitario'], 4, ',', '.') }}"
                                                                                                    placeholder="1,20">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="row">
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    for="example-date-input"
                                                                                                    class="form-label">Data</label>
                                                                                                <input class="form-control"
                                                                                                    type="text" disabled
                                                                                                    value="{{ \Carbon\Carbon::parse($produto['data'])->format('d/m/Y') }}"
                                                                                                    id="example-date-input">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    for="example-date-input"
                                                                                                    class="form-label">Data
                                                                                                    de
                                                                                                    atualização</label>
                                                                                                <input class="form-control"
                                                                                                    type="text" disabled
                                                                                                    value="{{ \Carbon\Carbon::parse($produto['updated_at'])->format('d/m/Y') }}"
                                                                                                    id="example-date-input">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    class="form-label">Quantidade</label>
                                                                                                <input class="form-control"
                                                                                                    type="text" disabled
                                                                                                    value="{{ number_format($produto['quantidade'], 2, ',', '.') }}">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        <!-- /.box -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" data-bs-dismiss="modal"
                                                                    aria-label="Close" class="btn btn-danger me-1">
                                                                    <i class="fas fa-close"></i> Fechar
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>

                                                <!-- EDITAR -->
                                                <div class="modal fade edit-product-modal_{{ $produto['id'] }}"
                                                    tabindex="-1" role="dialog" aria-labelledby="editProductModal"
                                                    aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myLargeModalLabel">Editar
                                                                    produto - {{ $produto['modelo'] }}</h4>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form class="form"
                                                                action="{{ route('produto.editar', ['id' => $produto['id']]) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-body">
                                                                    <div class="row justify-content-center">
                                                                        <div class="col-12">
                                                                            <div class="box">
                                                                                <!-- /.box-header -->

                                                                                <div class="box-body">
                                                                                    <hr class="my-15">
                                                                                    <div class="row">
                                                                                        <div class="col-md-3">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    class="form-label">Referência</label>
                                                                                                <input type="text"
                                                                                                    name="referencia"
                                                                                                    class="form-control"
                                                                                                    value="{{ $produto['referencia'] }}"
                                                                                                    placeholder="Referência">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-9">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    class="form-label">Modelo</label>
                                                                                                <input type="text"
                                                                                                    name="modelo"
                                                                                                    value="{{ $produto['modelo'] }}"
                                                                                                    class="form-control"
                                                                                                    placeholder="Modelo">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-6">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    class="form-label">Fornecedor</label>
                                                                                                <select
                                                                                                    name="fornecedor_id"
                                                                                                    class="form-select">
                                                                                                    <option selected
                                                                                                        value="{{ $produto['fornecedor_id'] }}">
                                                                                                        {{ $produto['fornecedor'] }}
                                                                                                    </option>
                                                                                                    @foreach ($data['fornecedores'] as $fornecedores)
                                                                                                        @if ($produto['fornecedor_id'] !== $fornecedores['id'])
                                                                                                            <option
                                                                                                                value="{{ $fornecedores['id'] }}">
                                                                                                                {{ $fornecedores['razao_social'] }}
                                                                                                            </option>
                                                                                                        @endif
                                                                                                    @endforeach

                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    class="form-label">Preço
                                                                                                    unitário</label>
                                                                                                <input type="text"
                                                                                                    id="preco_unitario_{{ $produto['id'] }}"
                                                                                                    name="preco_unitario"
                                                                                                    value="{{ number_format($produto['preco_unitario'], 4, ',', '.') }}"
                                                                                                    class="form-control preco-unitario"
                                                                                                    placeholder="R$0,00">
                                                                                            </div>
                                                                                        </div>

                                                                                        <script>
                                                                                            // Seleciona todos os inputs com a classe 'preco-unitario'
                                                                                            document.querySelectorAll('.preco-unitario').forEach(input => {
                                                                                                input.addEventListener('input', function(e) {
                                                                                                    let value = e.target.value.replace(/\D/g, '');

                                                                                                    if (value) {
                                                                                                        let reais = value.slice(0, -4) || '0';
                                                                                                        let centavos = value.slice(-4).padStart(4, '0');

                                                                                                        // Formatação
                                                                                                        let formattedValue = (parseInt(reais) + (parseInt(centavos) / 10000)).toLocaleString('pt-BR', {
                                                                                                            style: 'currency',
                                                                                                            currency: 'BRL',
                                                                                                            minimumFractionDigits: 4,
                                                                                                            maximumFractionDigits: 4
                                                                                                        });

                                                                                                        e.target.value = formattedValue;
                                                                                                    } else {
                                                                                                        e.target.value = '';
                                                                                                    }
                                                                                                });
                                                                                            });
                                                                                        </script>

                                                                                    </div>

                                                                                    <div class="row">
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    for="example-date-input"
                                                                                                    class="form-label">Data</label>
                                                                                                <input class="form-control"
                                                                                                    type="date"
                                                                                                    name="data"
                                                                                                    value="{{ $produto['data'] }}"
                                                                                                    id="example-date-input">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    for="example-date-input"
                                                                                                    class="form-label">Data
                                                                                                    de
                                                                                                    atualização</label>
                                                                                                <input class="form-control"
                                                                                                    type="text" readonly
                                                                                                    value="{{ \Carbon\Carbon::parse($produto['updated_at'])->format('d/m/Y') }}"
                                                                                                    id="example-date-input">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label class="form-label"
                                                                                                    for="quantidade">Quantidade</label>
                                                                                                <input class="form-control"
                                                                                                    id="quantidade_{{ $produto['id'] }}"
                                                                                                    name="quantidade"
                                                                                                    type="text"
                                                                                                    value="{{ number_format($produto['quantidade'], 2, ',', '.') }}" />
                                                                                            </div>

                                                                                            <script>
                                                                                                function formatarValor(valor) {
                                                                                                    valor = valor.replace(/\D/g, '');
                                                                                                    valor = (parseInt(valor, 10) / 100).toFixed(2);
                                                                                                    const partes = valor.split('.');
                                                                                                    partes[0] = partes[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                                                                                                    return partes.join(',');
                                                                                                }


                                                                                                document.getElementById("quantidade_{{ $produto['id'] }}").addEventListener('input', function() {
                                                                                                    const valorFormatado = formatarValor(this.value);

                                                                                                    if (valorFormatado == "NaN") {
                                                                                                        this.value = 0.00
                                                                                                    } else {
                                                                                                        this.value = valorFormatado;
                                                                                                    }
                                                                                                });
                                                                                            </script>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" data-bs-dismiss="modal"
                                                                        aria-label="Close" class="btn btn-danger me-1">
                                                                        <i class="fas fa-trash"></i> Cancelar
                                                                    </button>
                                                                    <button type="submit" class="btn btn-success">
                                                                        <i class="fas fa-save"></i> Salvar
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>

                                                <!-- DELETAR -->
                                                <div class="modal fade trash-product-modal_{{ $produto['id'] }}"
                                                    tabindex="-1" role="dialog" aria-labelledby="trashProductModal"
                                                    aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myLargeModalLabel">Excluir
                                                                    produto - {{ $produto['modelo'] }}</h4>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row justify-content-center">
                                                                    <div class="col-12">
                                                                        <div
                                                                            class="d-flex flex-column align-items-center justify-content-center">
                                                                            <i class="fas fa-warning"
                                                                                style="font-size: 50px; color:rgb(255, 196, 0);"></i>
                                                                            <h4 class="text-center">Ao confirmar, esse item
                                                                                será excluído permanentemente do seu
                                                                                estoque</h3>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <form
                                                                action="{{ route('produto.deletar', ['id' => $produto['id']]) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <div class="modal-footer">
                                                                    <button type="button" id="btn-no"
                                                                        data-bs-dismiss="modal" aria-label="Close"
                                                                        class="btn btn-danger me-1">
                                                                        <i class="fas fa-trash"></i> Não
                                                                    </button>
                                                                    <button type="submit" id="btn-yes"
                                                                        class="btn btn-success">
                                                                        <i class="fas fa-check"></i> Sim, excluir
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">Nenhum produto encontrado.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mb-20">
                                    {{ $data['paginate']->links() }}
                                </div>

                            <!-- /.box-body -->
                        </div>

                    </div>

                </div>

            </section>
            <!-- /.content -->
        </div>

    </div>

    <div class="modal fade value-product-modal" tabindex="-1" role="dialog" aria-labelledby="valueProductModal"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Alterar valor unitário</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="form" action="{{ route('produtos.alterar.unitario') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <div class="box">
                                    <livewire:estoque.subir-valor-unitario />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-danger me-1">
                            <i class="fas fa-trash"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <div class="modal fade value-product-geral-modal" tabindex="-1" role="dialog"
        aria-labelledby="valueProductGeralModal" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Alterar valor geral</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="form" action="{{ route('produtos.alterar.geral') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <div class="box">
                                    <!-- /.box-header -->

                                    <div class="box-body">
                                        <div class="row">
                                            <h5>Selecione o fornecedor</h5>
                                            <hr class="my-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">Fornecedor</label>
                                                    <select name="fornecedor_id" class="form-select">
                                                        @foreach ($data['fornecedores'] as $fornecedor)
                                                            <option value="{{ $fornecedor['id'] }}">
                                                                {{ $fornecedor['razao_social'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <h5>Ao alterar o valor unitário, todos os itens desse fornecedor terão seus
                                                valores unitários atualizados</h5>
                                            <label class="form-label">Valor unitário</label>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Preço unitário</label>
                                                    <input type="text" id="preco_unitario" name="preco_unitario"
                                                        class="form-control" placeholder="R$0,00">
                                                </div>
                                            </div>

                                            <script>
                                                document.getElementById('preco_unitario').addEventListener('input', function(e) {
                                                    let value = e.target.value.replace(/\D/g, '');
                                                    if (value) {
                                                        value = (value / 100).toLocaleString('pt-BR', {
                                                            style: 'currency',
                                                            currency: 'BRL'
                                                        });
                                                        e.target.value = value;
                                                    } else {
                                                        e.target.value = '';
                                                    }
                                                });
                                            </script>
                                        </div>

                                    </div>
                                    <!-- /.box -->
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-bs-dismiss="modal" aria-label="Close"
                                class="btn btn-danger me-1">
                                <i class="fas fa-trash"></i> Cancelar
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Salvar
                            </button>
                        </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection
