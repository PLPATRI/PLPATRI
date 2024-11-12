@section('title', 'Etiquetas - Combrim')

@extends('components.main')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Main content -->
            <section class="content">
                <div class="col-xxl-12 p-0">
                    <div class="box">
                        <div class="box-header with-border d-flex align-items-center justify-content-between">
                            <h4 class="box-title">Todos as etiquetas</h4>


                            <a data-bs-toggle="modal" data-bs-target=".criar-etiqueta-modal" class="btn btn-primary-light">
                                <i class="fas fa-plus"></i>
                                Criar etiqueta
                            </a>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nome (Razão Social)</th>
                                            <th>Rua</th>
                                            <th>Bairro</th>
                                            <th>Cidade</th>
                                            <th>CEP</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($etiquetas as $item)
                                            <tr>
                                                <td>#{{ $item->id }}</td>
                                                <td>{{ $item->razao_social }}</td>
                                                <td>{{ $item->rua }} - {{ $item->numero }}</td>
                                                <td>{{ $item->bairro }}</td>
                                                <td>{{ $item->cidade }}</td>
                                                <td>{{ $item->CEP }}</td>
                                                <td class="d-flex justify-content-center" style="gap: 15px">
                                                    <i data-bs-toggle="modal"
                                                        data-bs-target=".view-etiqueta-modal_{{ $item->id }}"
                                                        style="line-height: 1.7; font-size: 20px; cursor: pointer"
                                                        class="fas fa-eye"></i>
                                                    <form action="{{route('etiqueta.download.post')}}" method="post">
                                                        @csrf
                                                        @method('POST')
                                                        <input type="hidden" name="razao_social" value="{{$item->razao_social}}">
                                                        <input type="hidden" name="rua" value="{{ $item->rua }}">
                                                        <input type="hidden" name="bairro" value="{{ $item->bairro }}">
                                                        <input type="hidden" name="numero" value="{{ $item->numero }}">
                                                        <input type="hidden" name="cidade" value="{{ $item->cidade }}">
                                                        <input type="hidden" name="cep" value="{{ $item->CEP }}">
                                                        <input type="hidden" name="numero" value="{{ $item->numero }}">

                                                        <button type="submit" style="border: none; background-color: transparent">
                                                            <i style="line-height: 1.7; font-size: 20px; cursor: pointer"
                                                               class="fas fa-print"></i>
                                                        </button>
                                                    </form>
                                                    <i data-bs-toggle="modal"
                                                        data-bs-target=".delete-modal_{{ $item->id }}"
                                                        style="line-height: 1.7; font-size: 20px; cursor: pointer"
                                                        class="fas fa-trash"></i>
                                                </td>
                                            </tr>
                                            <!-- /.modal visualizar etiqueta -->
                                            <div class="modal fade view-etiqueta-modal_{{ $item->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="viewEtiquetaModal" aria-hidden="true"
                                                style="display: none;">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myLargeModalLabel">Visualizar
                                                                Etiqueta</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
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
                                                                                            <label class="form-label">Nome
                                                                                                ou Razão Social</label>
                                                                                            <input type="text"
                                                                                                value="{{ $item->razao_social }}"
                                                                                                disabled
                                                                                                class="form-control"
                                                                                                placeholder="José Luiz Datena">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                class="form-label">CEP</label>
                                                                                            <input type="number" disabled
                                                                                                value="{{ $item->CEP }}"
                                                                                                class="form-control"
                                                                                                placeholder="81.100-200">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                class="form-label">Cidade</label>
                                                                                            <input type="text" disabled
                                                                                                value="{{ $item->cidade }}"
                                                                                                class="form-control">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                class="form-label">Rua</label>
                                                                                            <input type="text" disabled
                                                                                                value="{{ $item->rua }}"
                                                                                                class="form-control"
                                                                                                placeholder="André de barros">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                class="form-label">Número</label>
                                                                                            <input type="number" disabled
                                                                                                value="{{ $item->numero }}"
                                                                                                class="form-control"
                                                                                                placeholder="131">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-4">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                class="form-label">Bairro</label>
                                                                                            <input type="text" disabled
                                                                                                value="{{ $item->bairro }}"
                                                                                                class="form-control"
                                                                                                placeholder="Centro">
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


                                            <!-- /.modal delete -->
                                            <div class="modal fade delete-modal_{{ $item->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="deleteModal" aria-hidden="true"
                                                style="display: none;">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myLargeModalLabel">Confirmar
                                                                exclusão da etiqueta?</h4>
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
                                                                        <h4 class="text-center">Ao confirmar, a etiqueta
                                                                            será deletada</h3>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer d-flex">
                                                            <button type="button" id="btn-no" data-bs-dismiss="modal"
                                                                aria-label="Close" class="btn btn-danger me-1">
                                                                <i class="fas fa-close"></i> Não
                                                            </button>
                                                            <form action="{{ route('etiqueta.delete') }}" method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input type="hidden" name="id"
                                                                    value="{{ $item->id }}">
                                                                <button type="submit" id="btn-yes"
                                                                    class="btn btn-success">
                                                                    <i class="fas fa-trash"></i> Sim
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>

                            <!-- Pagination Links -->

                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">
                                    <ul class="pagination">
                                        <li
                                            class="paginate_button page-item {{ $etiquetas->onFirstPage() ? 'disabled' : '' }}">
                                            <a href="{{ $etiquetas->previousPageUrl() }}" class="page-link"
                                                aria-controls="example1" tabindex="0">Voltar</a>
                                        </li>
                                        @foreach ($etiquetas->getUrlRange(1, $etiquetas->lastPage()) as $page => $url)
                                            <li
                                                class="paginate_button page-item {{ $page == $etiquetas->currentPage() ? 'active' : '' }}">
                                                <a href="{{ $url }}" class="page-link" aria-controls="example1"
                                                    tabindex="0">{{ $page }}</a>
                                            </li>
                                        @endforeach
                                        <li
                                            class="paginate_button page-item {{ $etiquetas->hasMorePages() ? '' : 'disabled' }}">
                                            <a href="{{ $etiquetas->nextPageUrl() }}" class="page-link"
                                                aria-controls="example1" tabindex="0">Proximo</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
                <!-- /.content -->
            </section>
        </div>
    </div>


    <!-- /.modal criar etiqueta -->
    <div class="modal fade criar-etiqueta-modal" tabindex="-1" role="dialog" aria-labelledby="criarEtiquetaModal"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Criar Etiqueta</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="form" action="{{ route('etiqueta.cadastrar.post') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <div class="box">
                                    <!-- /.box-header -->

                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">Nome ou Razão Social</label>
                                                    <select name="cliente_id" required class="form-select"
                                                        aria-label="Default select example">
                                                        @foreach ($clientes as $cliente)
                                                            <option value="{{ $cliente->id }}">
                                                                {{ $cliente->razao_social }}
                                                                <input type="hidden"
                                                                    value="{{ $cliente->razao_social }}"
                                                                    name="cliente_selecionado">
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">CEP</label>
                                                    <input type="text" required name="cep" class="form-control" id="cep" placeholder="82888-200" onblur="fetchAddress()" oninput="applyCepMask(event)">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Cidade</label>
                                                    <input type="text" required name="cidade" class="form-control" id="cidade" placeholder="Cidade">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Rua</label>
                                                    <input type="text" required name="rua" class="form-control" id="rua" placeholder="Endereço">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="form-label">Número</label>
                                                    <input type="number" required name="numero" class="form-control" placeholder="123">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Bairro</label>
                                                    <input type="text" required name="bairro" class="form-control" id="bairro" placeholder="Bairro">
                                                </div>
                                            </div>
                                        </div>

                                        <script>
                                            // Função para aplicar a máscara no campo de CEP
                                            function applyCepMask(event) {
                                                let cep = event.target.value.replace(/\D/g, ''); // Remove qualquer caractere não numérico
                                                if (cep.length > 5) {
                                                    cep = cep.replace(/(\d{5})(\d{3})/, '$1-$2'); // Adiciona o hífen
                                                }
                                                event.target.value = cep; // Atualiza o valor do campo com a máscara
                                            }

                                            // Função para buscar o endereço via API (viaCEP)
                                            function fetchAddress() {
                                                const cep = document.getElementById('cep').value.replace(/\D/g, ''); // Remove não-números
                                                if (cep.length === 8) { // Verifica se o CEP tem o tamanho correto (8 dígitos)
                                                    fetch(`https://viacep.com.br/ws/${cep}/json/`)
                                                        .then(response => response.json())
                                                        .then(data => {
                                                            if (!data.erro) {
                                                                document.getElementById('rua').value = data.logradouro;
                                                                document.getElementById('bairro').value = data.bairro;
                                                                document.getElementById('cidade').value = data.localidade;
                                                            } else {
                                                                alert('CEP não encontrado.');
                                                            }
                                                        })
                                                        .catch(error => {
                                                            console.error('Erro ao buscar o endereço:', error);
                                                        });
                                                } else {
                                                    alert('CEP inválido.');
                                                }
                                            }
                                        </script>


                                    </div>

                                </div>
                                <!-- /.box -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-danger me-1">
                            <i class="fas fa-close"></i> Fechar
                        </button>
                        <button type="submit" class="btn btn-success me-1">
                            <i class="fas fa-check"></i> Salvar
                        </button>
                        {{-- <button type="submit" class="btn btn-primary me-1">
                            <i class="fas fa-print"></i> Imprimir
                        </button> --}}
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>




    <!-- Vendor JS -->
    <script src="js/vendors.min.js"></script>
    <script src="js/pages/chat-popup.js"></script>
    <script src="https://etikto-admin-dashboard.multipurposethemes.com/bs5/assets/icons/feather-icons/feather.min.js">
    </script>

    <script
        src="https://etikto-admin-dashboard.multipurposethemes.com/bs5/assets/vendor_components/jquery-knob/js/jquery.knob.js">
    </script>

    <script src="https://etikto-admin-dashboard.multipurposethemes.com/bs5/assets/vendor_components/raphael/raphael.min.js">
    </script>
    <script
        src="https://etikto-admin-dashboard.multipurposethemes.com/bs5/assets/vendor_components/morris.js/morris.min.js">
    </script>
    <script
        src="https://etikto-admin-dashboard.multipurposethemes.com/bs5/assets/vendor_components/apexcharts-bundle/dist/apexcharts.js">
    </script>

    <!-- Etikto Admin App -->
    <script src="js/jquery.smartmenus.js"></script>
    <script src="js/menus.js"></script>
    <script src="js/template.js"></script>
    <script src="js/pages/dashboard2.js"></script>
    <script src="js/pages/calendar.js"></script>
@endsection
