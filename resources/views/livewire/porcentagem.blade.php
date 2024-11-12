@section('title', 'Porcentagem - Combrim')

<div>
    <form class="form" action="">
        <div class="box-body">
            <div class="row">
                <h5>Selecione o fornecedor</h5>
                <hr class="my-15">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">Fornecedor</label>
                        <select wire:model="fornecedor_id" wire:change="pegarProdutos" class="form-select">
                            <option selected>Selecionar Fornecedor</option>
                            @foreach($fornecedor as $item)
                                <option value="{{$item->id}}">{{$item->razao_social}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <hr class="my-15">
            <div class="row">
                <div class="d-flex align-items-center justify-content-between my-15">
                    <div>
                        <h5 class="mb-5">Selecione os itens</h5>
                        <div class="d-flex align-items-end">
                            <input type="checkbox" id="basic_checkbox_select_all" class="filled-in" wire:model="selectAll" wire:change="toggleSelectAll">
                            <label for="basic_checkbox_select_all"></label>
                            <p class="mx-10 mb-0">Selecionar todos</p>
                        </div>
                    </div>
                    <div class="form-group d-flex mb-0">
                        <input type="text" class="form-control w-75" placeholder="1" wire:model="filtro_um">
                        <input type="text" class="form-control w-75 mx-10" placeholder="100" wire:model="filtro_dois">
                        <a class="btn btn-primary-light" wire:click="filtroProdutos"><i class="fas fa-search"></i></a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th></th>
                            <th>ID</th>
                            <th>Referência</th>
                            <th>Modelo</th>
                            <th>Fornecedor</th>
                            <th>Valor Unitário</th>
                            <th>Porcentagem</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($produtos as $produto)
                            <tr>
                                <td class="d-flex justify-content-center" style="height: 62px">
                                    <input type="checkbox" wire:model="produtoAlterado.{{ $produto->id }}.selecionado" id="basic_checkbox_{{ $produto->id }}" class="filled-in">
                                    <label for="basic_checkbox_{{ $produto->id }}"></label>
                                </td>
                                <td>#{{ $produto->id }}</td>
                                <td>{{ $produto->referencia }}</td>
                                <td>{{ $produto->modelo }}</td>
                                <td>{{ $produto->fornecedor->razao_social }}</td>
                                <td>R$ {{ number_format($produto->preco_unitario, 4, ',', '.') }}</td>
                                <td>
                                    <div class="form-group mb-0">
                                        <input type="text" wire:model="produtoAlterado.{{ $produto->id }}.porcentagem" class="form-control w-75" placeholder="% 0,0">
                                    </div>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-xs btn-success" wire:click="alterarProdutos">
                                        <i class="fas fa-check"></i> Alterar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
    <hr>
    <div class="row p-4">
        <div class="col-12">
            <h5>Items alterados</h5>
            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Referência</th>
                        <th>Modelo</th>
                        <th>Fornecedor</th>
                        <th>Porcentagem</th>
                        <th>Valor Atualizado</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($produtosAlterados as $alterado)
                        <tr>
                            <td>{{ $alterado['referencia'] }}</td>
                            <td>{{ $alterado['modelo'] }}</td>
                            <td>{{ $alterado['fornecedor'] }}</td>
                            <td>{{ $alterado['porcentagem'] }} %</td>
                            <td>R$ {{ number_format($alterado['valor_atualizado'], 4, ',', '.') }}</td>
                            <td class="d-flex justify-content-center" style="gap: 15px">
                                <button wire:click="deleteProdutoAlterado({{ $alterado['íd_produto'] }})" style="border: none">
                                    <i
                                       style="line-height: 1.7; font-size: 20px; cursor: pointer" class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-danger me-1">
            <i class="fas fa-trash"></i> Cancelar
        </button>
        <button type="submit" class="btn btn-success" data-bs-toggle="modal" data-bs-target=".confirm-modal">
            <i class="fas fa-save"></i> Salvar
        </button>
    </div>



    <!-- /.modal confirm -->
    <div class="modal fade confirm-modal" tabindex="-1" role="dialog" aria-labelledby="confirmModal"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Confirmar alterações?</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <i class="fas fa-warning" style="font-size: 50px; color:rgb(255, 196, 0);"></i>
                                <h4 class="text-center">Ao confirmar, todas as porcentagens adicionas serão
                                    aplicadas em TODOS os itens do fornecedor.</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-no" data-bs-dismiss="modal" aria-label="Close"
                        class="btn btn-danger me-1">
                        <i class="fas fa-trash"></i> Não
                    </button>
                    <button type="button" id="btn-yes" wire:click="salvar" class="btn btn-success" onclick="reloadPage()">
                        <i class="fas fa-check"></i> Sim
                    </button>
                    <script>
                        function reloadPage() {
                            setTimeout(() => {
                                location.reload();
                            }, 100);
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>

    <!-- /.modal delete -->
    <div class="modal fade delete-modal" tabindex="-1" role="dialog" aria-labelledby="deleteModal"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Confirmar exclusão da alteração da porcentagem?
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <i class="fas fa-warning" style="font-size: 50px; color:rgb(255, 196, 0);"></i>
                                <h4 class="text-center">Ao confirmar, a aplicação da porcentagem será deletada!
                                    </h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-no" data-bs-dismiss="modal" aria-label="Close"
                        class="btn btn-danger me-1">
                        <i class="fas fa-close"></i> Não
                    </button>
                    <button type="submit" id="btn-yes" class="btn btn-success">
                        <i class="fas fa-trash"></i> Sim
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
