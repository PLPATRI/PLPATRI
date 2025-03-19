<div>
    <style>
        .table-responsive[wire\:loading\.remove] {
            display: block !important;
        }
    </style>
    <div class="modal fade add-item-modal" tabindex="-1" role="dialog" aria-labelledby="addItemModal" aria-hidden="true"
        style="display: none;" wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Selecione os produtos que serão adicionados</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                        <div class=" mb-15">
                            <label>Referência:</label>
                            <div class="form-group d-flex align-items-center">
                                <input type="text" class="form-control w-75 ms-10"
                                    wire:model.debounce.500ms="referencia_de" placeholder="Referência de">
                                <input type="text" class="form-control w-75 mx-10"
                                    wire:model.debounce.500ms="referencia_ate" placeholder="Referência até">
                                <button class="btn btn-primary-light btn-sm" wire:click="updateProdutos">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="form-group d-flex align-items-end mb-15">
                            <div>
                                <label>Modelo:</label>
                                <input type="text" wire:model.live='modelo' class="form-control" placeholder="1">
                            </div>
                        </div>
                        <div class="form-group d-flex align-items-end mb-15">
                            <div>
                                <label>Fornecedor:</label>
                                <input type="text" wire:model.live='fornecedor' class="form-control" placeholder="1">
                            </div>
                        </div>
                    </div>

                    <!-- Loading Indicator -->
                    <div wire:loading>
                        <div class="text-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Carregando...</span>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela de Produtos -->
                    <div class="table-responsive" wire:loading.remove>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Referência</th>
                                    <th>Modelo</th>
                                    <th>Quantidade</th>
                                    <th>Fornecedor</th>
                                    <th>Movimentação</th>
                                    <th>Valor Unitário</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($produtos as $produto)
                                    <tr>
                                        <td>
                                            <!-- Garantindo IDs exclusivos para checkboxes -->
                                            <input type="checkbox" wire:model="selectedProdutos"
                                                value="{{ $produto->id }}" id="checkbox_{{ $produto->id }}"
                                                class="filled-in">
                                            <label for="checkbox_{{ $produto->id }}"></label>
                                        </td>
                                        <td>{{ $produto->referencia }}</td>
                                        <td>{{ $produto->modelo }}</td>
                                        <td class="w-50">
                                            <div class="form-group">
                                                <input type="number" wire:model="quantidades.{{ $produto->id }}"
                                                    min="1" class="form-control" placeholder="Quantidade">
                                            </div>
                                        </td>
                                        <td>{{ $produto->fornecedor->razao_social }}</td>
                                        @if ($produto->quantidade < 0)
                                            <td style="color:rgb(255, 0, 0);">
                                                <i class="fas fa-warning" style="margin-right: 10px;"></i>
                                                <b>{{ $produto->quantidade }}</b>
                                            </td>
                                        @else
                                            <td><b>{{ $produto->quantidade }}</b></td>
                                        @endif
                                        <td><b>R$ {{ number_format($produto->preco_unitario, 4, ',', '.') }}</b></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-danger me-1">
                        <i class="fas fa-close"></i> Fechar
                    </button>
                    <button type="button" wire:click="confirmar" class="btn btn-success">
                        <i class="fas fa-check"></i> Confirmar
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
