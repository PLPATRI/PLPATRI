@section('title', 'Movimentações - Combrim')

<div>
    <div class="box">
        <div class="box-header with-border d-flex justify-content-between align-items-center">
            <h4 class="box-title">Movimentações</h4>
            <button type="button" data-bs-toggle="modal" data-bs-target="#modal-sintetico" class="btn btn-primary me-1">
                Relatório Sintético
            </button>
        </div>
        <form class="form" action="">
            <div class="box-body">
                <div class="row">
                    <h5>Selecione o fornecedor</h5>
                    <hr class="my-15">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Fornecedor</label>
                            <select wire:model="fornecedor_id" wire:change="mostrarProdutosFornecedores" class="form-select">
                                <option value="">Selecione um fornecedor</option>
                                @foreach($fornecedores as $item)
                                    <option value="{{ $item['id'] }}">{{ $item['razao_social'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <hr class="my-15">
                <div class="row justify-content-between">
                    <div class="col-lg-4">
                        <div class="d-flex align-items-center justify-content-between my-15">
                            <div class="form-group d-flex mb-0">
                                <input type="text" class="form-control w-75" placeholder="1" wire:model="filtro_um">
                                <input type="text" class="form-control w-75 mx-10" placeholder="100" wire:model="filtro_dois">
                                <a class="btn btn-primary-light" wire:click="filtroMovimentacoes"><i class="fas fa-search"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="d-flex align-items-center justify-content-center my-15">
                            <div class="form-group d-flex mb-0">
                                <input type="text" class="form-control mx-10" placeholder="Modelo" wire:model="">
                                <a class="btn btn-primary-light" wire:click=""><i class="fas fa-search"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="d-flex align-items-center justify-content-end my-15">
                            <div class="form-group d-flex mb-0">
                                <input type="text" class="form-control mx-10" placeholder="Fornecedor" wire:model="">
                                <a class="btn btn-primary-light" wire:click=""><i class="fas fa-search"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Modelo</th>
                                <th>Compra</th>
                                <th>Baixa</th>
                                <th>Tipo</th>
                                <th>Estoque</th>
                                <th>Dt. Reposição</th>
                                <th>Dt. Baixa</th>
                                <th>Fornecedor</th>
                                <th>Valor Unitário</th>
                                <th>Valor Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $totalCompra = 0;
                                $totalBaixa = 0;
                                $totalEstoque = 0;
                                $totalValorUnitario = 0;
                                $totalValorTotal = 0;
                            @endphp
                            @foreach($produtos as $produto)
                                @php
                                    $fornecedor = App\Models\Fornecedores::where('id', $produto['fornecedor'])->first();
                                    $totalCompra += $produto['compra'];
                                    $totalBaixa += $produto['baixa'];
                                    $totalEstoque += $produto['estoque'];
                                    $totalValorUnitario += $produto['valor_unitario'];
                                    $totalValorTotal += $produto['valor_total'];
                                @endphp
                                <tr>
                                    <td>{{ $produto['id'] }}</td>
                                    <td>{{ $produto['modelo'] }}</td>
                                    <td><b>{{ number_format($produto['compra'], 0) }}</b></td>
                                    <td><b>{{ number_format($produto['baixa'], 0) }}</b></td>
                                    <td>
                                        @if ($produto->baixa == 0)
                                            <b style="color:green">Compra</b>
                                        @endif  
                                        @if ($produto->compra == 0)   
                                            <b style="color:red">Venda</b>
                                        @endif  
                                    </td>

                                    @if($produto['estoque'] <= 0)
                                        <td style="color:red;">
                                            <i class="fas fa-warning" style="margin-right: 10px;"></i>
                                            <b>{{ number_format($produto['estoque'], 0) }}</b>
                                        </td>
                                    @else
                                        <td style="color:green;">
                                            <i class="fas fa-check" style="margin-right: 10px;"></i>
                                            <b>{{ number_format($produto['estoque'], 0) }}</b>
                                        </td>
                                    @endif
                                    <td>{{ \Carbon\Carbon::parse($produto['data_reposicao'])->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($produto['data_baixa'])->format('d/m/Y') }}</td>
                                    <td>{{ $fornecedor['razao_social'] }}</td>
                                    <td>R$ {{ number_format($produto['valor_unitario'], 4, ',', '.') }}</td>
                                    <td>R$ {{ number_format($produto['valor_total'], 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot style="background-color: #cccccc;">
                            <tr>
                                <th>Qtd. Total</th>
                                <th></th>
                                <th><b>{{ number_format($totalCompra, 0) }}</b></th>
                                <th><b>{{ number_format($totalBaixa, 0) }}</b></th>
                                <th><b>{{ number_format($produto['estoque'], 0) }}</b></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th><b>R$ {{ number_format($totalValorUnitario, 4, ',', '.') }}</b></th>
                                <th><b>R$ {{ number_format($totalValorTotal, 2, ',', '.') }}</b></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="modal modal-fill fade" data-backdrop="false" id="modal-sintetico" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content box">
                <div class="modal-header">
                    <h5 class="modal-title">Relatório Sintético</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead style="background-color: #cccccc;">
                            <tr>
                                <th>Estoque</th>
                                <th>Compra</th>
                                <th>Baixa</th>
                                <th>Fornecedor</th>
                                <th>Valor Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($produtos as $produto)
                                @php
                                    $fornecedor = App\Models\Fornecedores::find($produto['fornecedor']);
                                @endphp
                                <tr>
                                    <td @if($produto['estoque'] < 0) style="color:rgb(255, 0, 0);" @endif>
                                        <i class="fas fa-warning" style="margin-right: 10px;"></i>
                                        <b>{{ number_format($produto['estoque'], 0) }}</b>
                                    </td>
                                    <td><b>{{ number_format($produto['compra'], 0) }}</b></td>
                                    <td><b>{{ number_format($produto['baixa'], 0) }}</b></td>
                                    <td>{{ $fornecedor->razao_social ?? 'N/A' }}</td>
                                    <td>R$ {{ number_format($produto['valor_total'], 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot style="background-color: #cccccc;">
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>Total Geral</th>
                                <th>
                                    <b>
                                        R$ {{ number_format(collect($produtos)->sum('valor_total'), 2, ',', '.') }}
                                    </b>
                                </th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
