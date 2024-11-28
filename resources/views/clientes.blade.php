@section('title', 'Clientes - Combrim')

@extends('components.main')
@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Main content -->
            <section class="">
                <div class="row">
                    <div class="col-xxl-12">
                        <div class="box">
                            <div class="box-header with-border d-flex align-items-center justify-content-between">
                                <h4 class="box-title">Todos os clientes</h4>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="table-responsive">
                                    <div id="example1_wrapper"
                                        class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                                        <div class="row mb-3">
                                            <div class="col-12 col-md-12 mb-2 mb-md-0">
                                                <form action="{{ route('clientes.filtrar') }}" method="post"
                                                    id="filterForm">
                                                    @csrf
                                                    @method('POST')
                                                    <div class="dataTables_length" id="example1_length">
                                                        <label>Mostrar
                                                            <select name="paginacao" aria-controls="example1"
                                                                class="form-select form-control-sm" onchange="submitForm()">
                                                                <option value="1"
                                                                    {{ session('paginacao') == 1 ? 'selected' : '' }}>
                                                                    Limpar</option>
                                                                <option value="2"
                                                                    {{ session('paginacao') == 2 ? 'selected' : '' }}>2
                                                                </option>
                                                                <option value="10"
                                                                    {{ session('paginacao') == 10 ? 'selected' : '' }}>10
                                                                </option>
                                                                <option value="25"
                                                                    {{ session('paginacao') == 25 ? 'selected' : '' }}>25
                                                                </option>
                                                                <option value="50"
                                                                    {{ session('paginacao') == 50 ? 'selected' : '' }}>50
                                                                </option>
                                                                <option value="100"
                                                                    {{ session('paginacao') == 100 ? 'selected' : '' }}>100
                                                                </option>
                                                            </select> Resultados
                                                        </label>
                                                    </div>
                                                </form>

                                                <script>
                                                    function submitForm() {
                                                        document.getElementById('filterForm').submit();
                                                    }
                                                </script>

                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <form action="{{ route('clientes.filtrar') }}" method="post"
                                                class="d-flex flex-wrap col-12 col-md-6">
                                                @csrf
                                                @method('POST')
                                                <div class="col-12 col-sm-6 col-md-4 mb-2 pe-1">
                                                    <input type="text" class="form-control"
                                                        style="height: 42px;margin-left: -10px;" name="nome"
                                                        placeholder="Filtrar por nome" aria-controls="example1">
                                                </div>
                                                <div class="col-12 col-sm-6 col-md-4 mb-2 pe-1">
                                                    <input type="text" class="form-control"
                                                        style="height: 42px;margin-left: -5px;" name="documento"
                                                        placeholder="Filtrar por documento" aria-controls="example1">
                                                </div>
                                                <div class="col-12 col-md-2 mb-2">
                                                    <button class="btn btn-primary w-100">Filtrar</button>
                                                </div>
                                                <div class="col-12 col-md-2 mb-2">
                                                    <a href="http://localhost:8000/clientes" class="btn btn-secondary w-100"
                                                        style="">Limpar</a>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <table id="example1"
                                                    class="table table-bordered table-striped dataTable no-footer"
                                                    role="grid" aria-describedby="example1_info">
                                                    <thead>
                                                        <tr role="row">
                                                            <th class="sorting_asc" tabindex="0" aria-controls="example1"
                                                                rowspan="1" colspan="1" aria-sort="ascending"
                                                                aria-label="ID: activate to sort column descending"
                                                                style="width: 15.8125px;">ID</th>
                                                            <th class="sorting" tabindex="0" aria-controls="example1"
                                                                rowspan="1" colspan="1"
                                                                aria-label="Nome(Razão Social): activate to sort column ascending"
                                                                style="width: 131.656px;">Nome(Razão Social)</th>
                                                            <th class="sorting" tabindex="0" aria-controls="example1"
                                                                rowspan="1" colspan="1"
                                                                aria-label="Documento(CPF/CNPJ): activate to sort column ascending"
                                                                style="width: 151.344px;">Documento(CPF/CNPJ)</th>
                                                            <th class="sorting" tabindex="0" aria-controls="example1"
                                                                rowspan="1" colspan="1"
                                                                aria-label="Ações: activate to sort column ascending"
                                                                style="width: 74px;">Ações</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($data as $cliente)
                                                            <tr role="row" class="odd">
                                                                <td class="sorting_1">#{{ $cliente['id'] }}</td>
                                                                <td>{{ $cliente['razao_social'] }}</td>
                                                                <td>{{ $cliente['numero_documento'] }}</td>
                                                                <td class="d-flex justify-content-center" style="gap: 15px">
                                                                    <i data-bs-toggle="modal"
                                                                        data-bs-target="#view-client-cpf-modal-{{ $cliente['id'] }}"
                                                                        style="line-height: 1.7; font-size: 20px; cursor: pointer"
                                                                        class="fas fa-eye"></i>
                                                                    <i data-bs-toggle="modal"
                                                                        data-bs-target="#edit-client-cnpj-modal-{{ $cliente['id'] }}"
                                                                        style="line-height: 1.7; font-size: 20px; cursor: pointer"
                                                                        class="fas fa-edit"></i>
                                                                    <i data-bs-toggle="modal"
                                                                        data-bs-target="#trash-client-modal-{{ $cliente['id'] }}"
                                                                        style="line-height: 1.7; font-size: 20px; cursor: pointer"
                                                                        class="fas fa-trash"></i>
                                                                </td>
                                                            </tr>

                                                            <!-- Modal Visualizar Cliente -->
                                                            <div class="modal fade"
                                                                id="view-client-cpf-modal-{{ $cliente['id'] }}"
                                                                tabindex="-1" role="dialog"
                                                                aria-labelledby="viewClientCPFModal" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content"
                                                                        style="border-radius: 16px">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title">Visualizar Cliente - {{ $cliente['razao_social'] }}</h4>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="row justify-content-center">
                                                                                <div class="col-12">
                                                                                    <div class="box">
                                                                                        <form class="form"
                                                                                            action="">
                                                                                            <div class="box-body">
                                                                                                <div class="row">
                                                                                                    <div class="col-md-12">
                                                                                                        <div
                                                                                                            class="form-group">
                                                                                                            <label
                                                                                                                class="form-label">Razão
                                                                                                                Social</label>
                                                                                                            <input
                                                                                                                type="text"
                                                                                                                name="razao_social"
                                                                                                                class="form-control"
                                                                                                                disabled
                                                                                                                value="{{ $cliente['razao_social'] }}"
                                                                                                                required>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="row">
                                                                                                    @if ($cliente['transportadora'])
                                                                                                        <div
                                                                                                            class="col-md-6">
                                                                                                            <div
                                                                                                                class="form-group">
                                                                                                                <label
                                                                                                                    class="form-label">Documento
                                                                                                                    (CNPJ)
                                                                                                                </label>
                                                                                                                <input
                                                                                                                    type="text"
                                                                                                                    name="numero_documento"
                                                                                                                    class="form-control"
                                                                                                                    oninput="maskCNPJ(this)"
                                                                                                                    disabled
                                                                                                                    value="{{ $cliente['numero_documento'] }}"
                                                                                                                    required>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="col-md-6">
                                                                                                            <div
                                                                                                                class="form-group">
                                                                                                                <label
                                                                                                                    class="form-label">Transportadora</label>
                                                                                                                <input
                                                                                                                    type="text"
                                                                                                                    name="transportadora"
                                                                                                                    class="form-control"
                                                                                                                    disabled
                                                                                                                    value="{{ $cliente['transportadora'] }}">
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    @else
                                                                                                        <div
                                                                                                            class="col-md-12">
                                                                                                            <div
                                                                                                                class="form-group">
                                                                                                                <label
                                                                                                                    class="form-label">Documento
                                                                                                                    (CNPJ)</label>
                                                                                                                <input
                                                                                                                    type="text"
                                                                                                                    name="numero_documento"
                                                                                                                    class="form-control"
                                                                                                                    oninput="maskCNPJ(this)"
                                                                                                                    disabled
                                                                                                                    value="{{ $cliente['numero_documento'] }}"
                                                                                                                    required>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    @endif
                                                                                                </div>
                                                                                                <div class="row">
                                                                                                    @if ($cliente['inscricao_estadual'])
                                                                                                        <div
                                                                                                            class="col-md-12">
                                                                                                            <div
                                                                                                                class="form-group">
                                                                                                                <label
                                                                                                                    class="form-label">Inscrição
                                                                                                                    Estadual</label>
                                                                                                                <input
                                                                                                                    type="text"
                                                                                                                    name="inscricao_estadual"
                                                                                                                    class="form-control"
                                                                                                                    disabled
                                                                                                                    value="{{ $cliente['inscricao_estadual'] }}">
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-md-6">
                                                                                                            <div class="form-group">
                                                                                                                <label class="form-label">Email</label>
                                                                                                                <input
                                                                                                                    type="email"
                                                                                                                    name="email"
                                                                                                                    class="form-control"
                                                                                                                    disabled
                                                                                                                    value="{{ $cliente['email'] }}"
                                                                                                                    required>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-md-6">
                                                                                                            <div class="form-group">
                                                                                                                <label class="form-label">Segundo Email</label>
                                                                                                                <input
                                                                                                                    type="second_email"
                                                                                                                    name="second_email"
                                                                                                                    class="form-control"
                                                                                                                    disabled
                                                                                                                    value="{{ $cliente['second_email'] }}"
                                                                                                                    required>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                @else
                                                                                                <div class="col-md-6">
                                                                                                    <div
                                                                                                        class="form-group">
                                                                                                        <label
                                                                                                            class="form-label">Email</label>
                                                                                                        <input
                                                                                                            type="email"
                                                                                                            name="email"
                                                                                                            disabled
                                                                                                            class="form-control"
                                                                                                            value="{{ $cliente['email'] }}"
                                                                                                            required>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-md-6">
                                                                                                    <div
                                                                                                        class="form-group">
                                                                                                        <label
                                                                                                            class="form-label">Segundo Email</label>
                                                                                                        <input
                                                                                                            type="second_email"
                                                                                                            name="second_email"
                                                                                                            disabled
                                                                                                            class="form-control"
                                                                                                            value="{{ $cliente['second_email'] }}"
                                                                                                            required>
                                                                                                    </div>
                                                                                                </div>
                                                        @endif

                                            </div>
                                            <div class="row">

                                                @if ($cliente['celular'])
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Telefone</label>
                                                            <input type="text" name="telefone" disabled
                                                                class="form-control" oninput="maskCell(this)"
                                                                value="{{ $cliente['telefone'] }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Celular</label>
                                                            <input type="text" name="celular" class="form-control"
                                                                disabled oninput="maskCell(this)"
                                                                value="{{ $cliente['celular'] }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">CEP</label>
                                                            <input type="text" disabled name="cep"
                                                                class="form-control" value="{{ $cliente['cep'] }}"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Cidade</label>
                                                            <input type="text" disabled name="cidade"
                                                                class="form-control" value="{{ $cliente['cidade'] }}"
                                                                required>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="form-label">Telefone</label>
                                                            <input type="text" name="telefone" disabled
                                                                oninput="maskCell(this)" class="form-control"
                                                                value="{{ $cliente['telefone'] }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="form-label">CEP</label>
                                                            <input type="text" disabled name="cep"
                                                                class="form-control" value="{{ $cliente['cep'] }}"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label class="form-label">Cidade</label>
                                                            <input type="text" disabled name="cidade"
                                                                class="form-control" value="{{ $cliente['cidade'] }}"
                                                                required>
                                                        </div>
                                                    </div>
                                                @endif

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label class="form-label">Endereço</label>
                                                            <input type="text" disabled name="endereco"
                                                                class="form-control" value="{{ $cliente['endereco'] }}"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label class="form-label">Número</label>
                                                            <input type="text" disabled name="numero"
                                                                class="form-control" value="{{ $cliente['numero'] }}"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="form-label">Bairro</label>
                                                            <input type="text" name="bairro" disabled
                                                                class="form-control" value="{{ $cliente['bairro'] }}"
                                                                disabled required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label class="form-label">UF</label>
                                                            <input type="text" name="uf" disabled
                                                                class="form-control" value="{{ $cliente['uf'] }}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Observações</label>
                                                            <textarea  name="observacoes" disabled
                                                                class="form-control" placeholder="{{ $cliente['observacoes'] }}" required></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-bs-dismiss="modal" aria-label="Close"
                                class="btn btn-danger me-1">
                                <i class="fas fa-close"></i> Fechar
                            </button>
                        </div>
                    </div>
                </div>
        </div>

        <!-- Modal Editar Cliente -->
        <div class="modal fade" id="edit-client-cnpj-modal-{{ $cliente['id'] }}" tabindex="-1" role="dialog"
            aria-labelledby="editClientCNPJModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="border-radius: 16px">
                    <div class="modal-header">
                        <h4 class="modal-title">Editar Cliente - {{ $cliente['razao_social'] }}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <div class="box">
                                    <form id="edit-client-form-{{ $cliente['id'] }}"
                                        action="{{ route('clientes.editar.post', ['id' => $cliente['id']]) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Cliente</label>
                                                        <input type="text" name="razao_social" class="form-control"
                                                            value="{{ $cliente['razao_social'] }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                @if ($cliente['tipo_documento'] === 'CPF')
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Documento
                                                                (CPF)</label>
                                                            <input type="text" name="numero_documento"
                                                                class="form-control" oninput="maskCPF(this)"
                                                                value="{{ $cliente['numero_documento'] }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Email</label>
                                                            <input type="email" name="email" class="form-control"
                                                                value="{{ $cliente['email'] }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Segundo Email</label>
                                                            <input type="email" name="second_email"
                                                                class="form-control"
                                                                value="{{ $cliente['second_email'] }}" required>
                                                        </div>
                                                    </div>
                                                @else
                                                    @if ($cliente['transportadora'])
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Documento
                                                                    (CNPJ)</label>
                                                                <input type="text" name="numero_documento"
                                                                    class="form-control" oninput="maskCNPJ(this)"
                                                                    value="{{ $cliente['numero_documento'] }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Transportadora</label>
                                                                <input type="text" name="transportadora"
                                                                    class="form-control"
                                                                    value="{{ $cliente['transportadora'] }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6"> 
                                                            <div class="form-group">
                                                                <label class="form-label">Responsavel
                                                                    Transportadora</label>
                                                                <input type="text" name="responsavel_transportadora"
                                                                    class="form-control"
                                                                    value="{{ $cliente['responsavel_transportadora'] }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Telefone Transportadora</label>
                                                                <input type="text" name="numero_transportadora"
                                                                    class="form-control" oninput="maskCell(this)"
                                                                    value="{{ $cliente['numero_transportadora'] }}">
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Documento
                                                                    (CNPJ)</label>
                                                                <input type="text" name="numero_documento"
                                                                    class="form-control" oninput="maskCNPJ(this)"
                                                                    value="{{ $cliente['numero_documento'] }}" required>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="row">
                                                @if ($cliente['inscricao_estadual'])
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Inscrição
                                                                Estadual</label>
                                                            <input type="text" name="inscricao_estadual"
                                                                class="form-control"
                                                                value="{{ $cliente['inscricao_estadual'] }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Email</label>
                                                            <input type="email" name="email" class="form-control"
                                                                value="{{ $cliente['email'] }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Segundo Email</label>
                                                            <input type="email" name="second_email"
                                                                class="form-control"
                                                                value="{{ $cliente['second_email'] }}" required>
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>
                                            <div class="row">

                                                @if ($cliente['celular'])
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="form-label">Telefone</label>
                                                            <input type="text" name="telefone" class="form-control"
                                                                oninput="maskCell(this)"
                                                                value="{{ $cliente['telefone'] }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="form-label">Celular</label>
                                                            <input type="text" name="celular" class="form-control"
                                                                oninput="maskCell(this)"
                                                                value="{{ $cliente['celular'] }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="form-label">CEP</label>
                                                            <input type="text" id="cep-{{ $cliente['id'] }}"
                                                                name="cep" class="form-control"
                                                                value="{{ $cliente['cep'] }}" required>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Telefone</label>
                                                            <input type="text" name="telefone"
                                                                oninput="maskCell(this)" class="form-control"
                                                                value="{{ $cliente['telefone'] }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">CEP</label>
                                                            <input type="text" id="cep-{{ $cliente['id'] }}"
                                                                name="cep" class="form-control"
                                                                value="{{ $cliente['cep'] }}" required>
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>
                                            <div class="row">

                                                <div class="col-md-10">
                                                    <div class="form-group">
                                                        <label class="form-label">Endereço</label>
                                                        <input type="text" id="endereco-{{ $cliente['id'] }}"
                                                            name="endereco" class="form-control"
                                                            value="{{ $cliente['endereco'] }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label class="form-label">Número</label>
                                                        <input type="text" id="numero-{{ $cliente['id'] }}"
                                                            name="numero" class="form-control"
                                                            value="{{ $cliente['numero'] }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Bairro</label>
                                                        <input type="text" id="bairro-{{ $cliente['id'] }}"
                                                            name="bairro" class="form-control"
                                                            value="{{ $cliente['bairro'] }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label class="form-label">Cidade</label>
                                                            <input type="text" id="cidade"
                                                                name="cidade" class="form-control"
                                                                value="{{ $cliente['cidade'] }}" required>
                                                        </div>
                                                    </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">UF</label>
                                                        <input type="text" name="uf" class="form-control"
                                                            value="{{ $cliente['uf'] }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group">
                                                    <label class="form-label">Observações</label>
                                                    <textarea name="observacoes" class="form-control" placeholder="{{ $cliente['observacoes'] }}"></textarea>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger"
                                                data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-success">Alterar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.getElementById('cep-{{ $cliente['id'] }}').addEventListener('blur', function() {
                var cep = this.value.replace(/\D/g, '');
                if (cep.length === 8) {
                    fetch(`https://viacep.com.br/ws/${cep}/json/`)
                        .then(response => response.json())
                        .then(data => {
                            if (!data.erro) {
                                document.getElementById('endereco-{{ $cliente['id'] }}').value = data.logradouro;
                                document.getElementById('bairro-{{ $cliente['id'] }}').value = data.bairro;
                                document.getElementById('cidade-{{ $cliente['id'] }}').value = data.localidade;
                                document.getElementById('uf-{{ $cliente['id'] }}').value = data.uf;
                            } else {
                                alert('CEP não encontrado.');
                            }
                        })
                        .catch(error => {
                            console.error('Erro ao buscar CEP:', error);
                        });
                } else {
                    alert('CEP inválido. Deve conter 8 dígitos.');
                }
            });
        </script>

        <!-- Modal Excluir Cliente -->
        <div class="modal fade" id="trash-client-modal-{{ $cliente['id'] }}" tabindex="-1" role="dialog"
            aria-labelledby="trashclientModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="border-radius: 16px">
                    <div class="modal-header">
                        <h4 class="modal-title">Excluir Cliente - {{ $cliente['razao_social'] }}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    <i class="fas fa-warning" style="font-size: 50px; color:rgb(255, 196, 0);"></i>
                                    <h4 class="text-center">Ao
                                        confirmar, esse item será
                                        excluído permanentemente do seu
                                        estoque</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('clientes.deletar.post', ['id' => $cliente['id']]) }}" method="post"
                        class="d-flex">
                        @csrf
                        @method('DELETE')
                        <div class="modal-footer">
                            <button type="button" id="btn-no" data-bs-dismiss="modal" aria-label="Close"
                                class="btn btn-danger me-1">
                                <i class="fas fa-trash"></i> Não
                            </button>

                            <button type="submit" id="btn-yes" class="btn btn-success">
                                <i class="fas fa-check"></i> Sim,
                                excluir
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach

        </tbody>
        </table>
    </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-5">
            <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">Showing 1 to 2 of 2
                entries</div>
        </div>
        <div class="col-sm-12 col-md-7">
            <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">
                <ul class="pagination">
                    <li class="paginate_button page-item {{ $data->onFirstPage() ? 'disabled' : '' }}">
                        <a href="{{ $data->previousPageUrl() }}" class="page-link" aria-controls="example1"
                            tabindex="0">Voltar</a>
                    </li>
                    @foreach ($data->getUrlRange(1, $data->lastPage()) as $page => $url)
                        <li class="paginate_button page-item {{ $page == $data->currentPage() ? 'active' : '' }}">
                            <a href="{{ $url }}" class="page-link" aria-controls="example1"
                                tabindex="0">{{ $page }}</a>
                        </li>
                    @endforeach
                    <li class="paginate_button page-item {{ $data->hasMorePages() ? '' : 'disabled' }}">
                        <a href="{{ $data->nextPageUrl() }}" class="page-link" aria-controls="example1"
                            tabindex="0">Proximo</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    <!-- /.box-body -->
    </div>
    </div>
    </div>
    </section>
    <!-- /.content -->
    </div>
    </div>
    <!-- /.modal edit CPF -->
    <div class="modal fade edit-client-cpf-modal" tabindex="-1" role="dialog" aria-labelledby="editClientCPFModal"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Editar Cliente - {{ $cliente['razao_social'] }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="box">
                                <!-- /.box-header -->
                                <form class="form" action="">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">Nome</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="José Luiz Datena">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-7">
                                                <div class="form-group">
                                                    <label class="form-label">Endereço</label>
                                                    <input type="text" class="form-control" placeholder="Endereço">
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="form-label">Telefone de Contato</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="(00) 9999-9999">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="form-label">Documento (CPF)</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="123.456.789-10">
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="form-group">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" class="form-control"
                                                        placeholder="name@mail.com">
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
                    <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-danger me-1">
                        <i class="fas fa-trash"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Salvar
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal edit CNPJ -->
    <div class="modal fade edit-client-cnpj-modal" tabindex="-1" role="dialog" aria-labelledby="editClientCNPJModal"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Editar Cliente - {{ $cliente['razao_social'] }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="box">
                                <!-- /.box-header -->
                                <form class="form" action="">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">Razão Social</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Razão Social">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Inscrição Estadual</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Email</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="razaosocial@mail.com">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Telefone</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="(00) 0000-0000">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Celular</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="(00) 0000-0000">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Endereço</label>
                                                    <input type="text" class="form-control" placeholder="Endereço">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Cidade</label>
                                                    <input type="text" class="form-control" placeholder="Cidade">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="form-label">UF</label>
                                                    <select class="form-select">
                                                        <option>PR</option>
                                                        <option>RR</option>
                                                        <option>AM</option>
                                                        <option>SP</option>
                                                        <option>SC</option>
                                                        <option>RS</option>
                                                        <option>RN</option>
                                                        <option>MT</option>
                                                        <option>RJ</option>
                                                        <option>MS</option>
                                                        <option>MG</option>
                                                        <option>AC</option>
                                                        <option>TO</option>
                                                        <option>SE</option>
                                                        <option>AL</option>
                                                        <option>PE</option>
                                                        <option>ES</option>
                                                        <option>CE</option>
                                                        <option>GO</option>
                                                        <option>BA</option>
                                                        <option>PA</option>
                                                        <option>MA</option>
                                                        <option>PI</option>
                                                        <option>PB</option>
                                                        <option>RO</option>
                                                        <option>AP</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Bairro</label>
                                                    <input type="text" class="form-control" placeholder="Bairro">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">CEP</label>
                                                    <input type="text" class="form-control" placeholder="99.999-99">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Documento (CNPJ)</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="12.345.678/001-10">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Transportadora</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Nome da transportadora">
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
                    <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-danger me-1">
                        <i class="fas fa-trash"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Salvar
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- /.modal view CPF -->
    <div class="modal fade view-client-cpf-modal" tabindex="-1" role="dialog" aria-labelledby="viewClientCPFModal"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Visualizar Cliente - {{ $cliente['razao_social'] }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="box">
                                <!-- /.box-header -->
                                <form class="form" action="">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">Nome</label>
                                                    <input type="text" disabled class="form-control"
                                                        placeholder="José Luiz Datena">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-7">
                                                <div class="form-group">
                                                    <label class="form-label">Endereço</label>
                                                    <input type="text" disabled class="form-control"
                                                        placeholder="Endereço">
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="form-label">Telefone de Contato</label>
                                                    <input type="text" disabled class="form-control"
                                                        placeholder="(00) 9999-9999">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="form-label">Documento (CPF)</label>
                                                    <input type="text" disabled class="form-control"
                                                        placeholder="123.456.789-10">
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="form-group">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" disabled class="form-control"
                                                        placeholder="name@mail.com">
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
                    <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-danger me-1">
                        <i class="fas fa-close"></i> Fechar
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- /.modal view CNPJ -->
    <div class="modal fade view-client-cnpj-modal" tabindex="-1" role="dialog" aria-labelledby="viewclienCNPJtModal"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Visualizar Cliente - {{ $cliente['razao_social'] }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="box">
                                <!-- /.box-header -->
                                <form class="form" action="">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">Razão Social</label>
                                                    <input type="text" disabled class="form-control"
                                                        placeholder="Razão Social">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Inscrição Estadual</label>
                                                    <input type="text" disabled class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Email</label>
                                                    <input type="text" disabled class="form-control"
                                                        placeholder="razaosocial@mail.com">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Telefone</label>
                                                    <input type="text" disabled class="form-control"
                                                        placeholder="(00) 0000-0000">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Celular</label>
                                                    <input type="text" disabled class="form-control"
                                                        placeholder="(00) 0000-0000">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Endereço</label>
                                                    <input type="text" disabled class="form-control"
                                                        placeholder="Endereço">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Cidade</label>
                                                    <input type="text" disabled class="form-control"
                                                        placeholder="Cidade">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="form-label">UF</label>
                                                    <input type="text" disabled class="form-control" placeholder="UF">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Bairro</label>
                                                    <input type="text" disabled class="form-control"
                                                        placeholder="Bairro">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">CEP</label>
                                                    <input type="text" disabled class="form-control"
                                                        placeholder="99.999-99">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Documento (CNPJ)</label>
                                                    <input type="text" disabled class="form-control"
                                                        placeholder="12.345.678/001-10">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Transportadora</label>
                                                    <input type="text" disabled class="form-control"
                                                        placeholder="Nome da transportadora">
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
                    <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-danger me-1">
                        <i class="fas fa-close"></i> Fechar
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- /.modal trash -->
    <div class="modal fade trash-client-modal" tabindex="-1" role="dialog" aria-labelledby="trashclientModal"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Excluir Cliente - {{ $cliente['razao_social'] }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <i class="fas fa-warning" style="font-size: 50px; color:rgb(255, 196, 0);"></i>
                                <h4 class="text-center">Ao confirmar, esse item será excluído permanentemente do seu
                                    estoque</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-no" data-bs-dismiss="modal" aria-label="Close"
                        class="btn btn-danger me-1">
                        <i class="fas fa-trash"></i> Não
                    </button>
                    <button type="submit" id="btn-yes" class="btn btn-success">
                        <i class="fas fa-check"></i> Sim, excluir
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <script>
        function maskPhone(input) {
            let value = input.value.replace(/\D/g, '');
            if (value.length > 11) value = value.slice(0, 11); // Limita a 11 dígitos
            if (value.length > 10) {
                input.value = value.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
            } else if (value.length > 6) {
                input.value = value.replace(/^(\d{2})(\d{4})(\d{0,4})$/, '($1) $2-$3');
            } else if (value.length > 2) {
                input.value = value.replace(/^(\d{2})(\d{0,4})$/, '($1) $2');
            } else {
                input.value = value;
            }
        }

        function maskCell(input) {
            let value = input.value.replace(/\D/g, '');
            if (value.length > 11) value = value.slice(0, 11); // Limita a 11 dígitos
            input.value = value.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
        }

        function maskCPF(input) {
            let value = input.value.replace(/\D/g, '');
            if (value.length > 11) value = value.slice(0, 11); // Limita a 11 dígitos
            input.value = value.replace(/^(\d{3})(\d{3})(\d{3})(\d{2})$/, '$1.$2.$3-$4');
        }

        function maskCNPJ(input) {
            let value = input.value.replace(/\D/g, '');
            if (value.length > 14) value = value.slice(0, 14); // Limita a 14 dígitos
            input.value = value.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/, '$1.$2.$3/$4-$5');
        }

        function maskIE(input) {
            let value = input.value.replace(/\D/g, '');
            if (value.length > 9) value = value.slice(0, 9); // Limita a 9 dígitos
            input.value = value.replace(/^(\d{2})(\d{3})(\d{3})$/, '$1.$2.$3');
        }
    </script>
@endsection
