@section('title', 'Carregar Estoque - Combrim')
<div>
    <div class="box-header with-border d-flex align-items-center justify-content-between">
        <h4 class="box-title">Carregamento de estoque</h4>
        <a data-bs-toggle="modal" data-bs-target=".view-carregamento-modal" class="btn btn-primary">
            Visualizar Carregamentos
        </a>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <form class="form" action="">
                    <h5 class="box-title">Selecione o fornecedor</h5>
                    <div class="form-group">
                        <select class="form-select" wire:model.live="id_fornecedor">
                            <option value="">Selecione um fornecedor</option>
                            @foreach ($fornecedores as $fornecedor)
                                <option value="{{ $fornecedor['id'] }}">
                                    {{ $fornecedor->razao_social }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
        </div>
        <hr class="my-15">
        <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        {{-- <th></th> --}}
                        <th>ID</th>
                        <th>Referência</th>
                        <th>Modelo</th>
                        <th>Fornecedor</th>
                        <th>Movimentação</th>
                        <th>Estoque de segurança</th>
                        <th>Valor Unitário</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produtos as $produto)
                        <tr>
                            {{-- <td class="">
                                <input type="checkbox" id="basic_checkbox_1" class="filled-in">
                                <label for="basic_checkbox_1"></label>
                            </td> --}}
                            <td>#{{ $produto->id }}</td>
                            <td>{{ $produto->referencia }}</td>
                            <td>{{ $produto->modelo }}</td>
                            <td>{{ $getFornecedor->razao_social }}</td>

                            @if ($produto->quantidade <= $produto->estoque_seguranca)
                                <td style="color:rgb(255, 0, 0);"><i class="fas fa-warning"
                                        style="margin-right: 10px;"></i><b>{{ $produto->quantidade }}</b></td>
                            @else
                                <td style="color:green">
                                    <i class="fas fa-check"
                                        style="margin-right: 10px;"></i><b>{{ number_format($produto->quantidade, 2, ',', '.') }}</b>
                                </td>
                            @endif
                            <td>{{ $produto->estoque_seguranca }}</td>
                            <td>R$ {{ number_format($produto->preco_unitario, 4, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <hr class="my-15">
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <form wire:submit.prevent="aplicar" class="form">
                    <div class="box-body">
                        @foreach ($produtos as $produto)
                            <hr class="my-15">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Referência</label>
                                        <input type="text" disabled class="form-control"
                                            value="{{ $produto->referencia }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Modelo</label>
                                        <input type="text" disabled class="form-control"
                                            value="{{ $produto->modelo }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="data-input-{{ $produto->id }}" class="form-label">Data</label>
                                        <input class="form-control" type="date" disabled
                                            value="{{ $produto->data }}" id="data-input-{{ $produto->id }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="data_carregamento_{{ $produto->id }}" class="form-label">Data de
                                            carregamento*</label>
                                        <input class="form-control" required type="date"
                                            wire:model.defer="produtosCarregamento.{{ $produto->id }}.data_carregamento"
                                            id="data_carregamento_{{ $produto->id }}">
                                        @error('produtosCarregamento.' . $produto->id . '.data_carregamento')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Preço unitário*</label>
                                        <input type="number" required
                                            wire:model.defer="produtosCarregamento.{{ $produto->id }}.preco_unitario"
                                            class="form-control" placeholder="R$0,00">
                                        @error('produtosCarregamento.' . $produto->id . '.preco_unitario')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-label">Quantidade*</label>
                                        <input class="form-control" required
                                            wire:model.defer="produtosCarregamento.{{ $produto->id }}.quantidade"
                                            type="number" placeholder="0">
                                        @error('produtosCarregamento.' . $produto->id . '.quantidade')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="box-footer d-flex flex-column align-items-center">
                        <div class="d-flex">
                            <button type="button" class="btn btn-danger me-1" wire:click="deleteCarregamentos()">
                                <i class="fas fa-trash"></i> Cancelar
                            </button>
                            @if ($salvado)
                                <!-- Verifica se os dados foram salvos em sessão -->
                                <button type="button" class="btn btn-primary me-1" wire:click="confirmarCadastro">
                                    <i class="fas fa-check"></i> Confirmar Cadastro
                                </button>
                            @else
                                <button type="button" class="btn btn-success me-1" wire:click="salvarAgora">
                                    <i class="fas fa-save"></i> Salvar
                                </button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div class="modal fade view-carregamento-modal" tabindex="-1" role="dialog"
        aria-labelledby="viewCarregamentoModal" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Todos os Carregamentos</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-body">
                                    <div class="table-responsive px-2" style="margin: 0px 2px;">
                                        <table class="table table-responsive mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Data</th>
                                                    <th>Modelo</th>
                                                    <th>Quantidade</th>
                                                    <th>Valor Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($this->getCarregamentos() as $id => $carregamento)
                                                    <tr class="text-fade">
                                                        <td>#{{ $carregamento['id'] }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($carregamento['data_carregamento'])->format('d/m/Y') }}
                                                        </td>
                                                        <td>{{ $carregamento['modelo'] ?? 'Modelo Desconhecido' }}</td>
                                                        <td>{{ $carregamento['quantidade'] }}</td>
                                                        <td>R$
                                                            {{ number_format($carregamento['preco_unitario'] * $carregamento['quantidade'], 2, ',', '.') }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
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
                    <button type="button" wire:click="deleteCarregamentos" class="btn btn-danger">
                        Deletar Carregamentos
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</div>
