@section('title', 'Movimentações - Combrim')

@extends('components.main')
@section('content')
    @php
        $totalCompra = 0;
        $totalBaixa = 0;
        $totalEstoque = 0;
        $totalValorUnitario = 0;
        $totalValorTotal = 0;
    @endphp

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Main content -->
            <section class="content">
                <div class="row justify-content-center">
                    <div class="col-lg-12 col-12">
                        <div class="box">
                            <div class="box-header with-border d-flex justify-content-between align-items-center">
                                <h4 class="box-title">Movimentações</h4>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#modal-sintetico"
                                    class="btn btn-primary me-1">
                                    Relatório Sintético
                                </button>
                            </div>
                            <form method="GET" action="{{ route('movimentacoes.get') }}" class="form">
                                <div class="box-body">
                                    <div class="row">
                                        <h5>Selecione o fornecedor</h5>
                                        <hr class="my-15">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Fornecedor</label>
                                                <select name="fornecedor_id" class="form-select"
                                                    onchange="this.form.submit()">
                                                    <option value="todos" selected>Todos</option>
                                                    @foreach ($fornecedores as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ $fornecedor_id == $item->id ? 'selected' : '' }}>
                                                            {{ $item->razao_social }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-15">
                                    <div class="row justify-content-between align-items-center my-15">
                                        <div class="col-6 d-flex align-items-center">
                                            <div class="form-group align-items-center d-flex">
                                                <input type="text" class="form-control" placeholder="Referência de"
                                                    name="referencia_de" value="{{ request('referencia_de') }}">
                                                <span class="mx-2">até</span>
                                                <input type="text" class="form-control" placeholder="Referência até"
                                                    name="referencia_ate" value="{{ request('referencia_ate') }}">
                                                <button type="submit" class="btn btn-sm btn-primary ms-2">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-6 d-flex justify-content-end align-items-center">
                                            <div class="form-group align-items-center d-flex">
                                                <input type="text" class="form-control" placeholder="Modelo"
                                                    name="modelo" value="{{ request('modelo') }}">
                                                <button type="submit" class="btn btn-sm btn-primary ms-2">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Referência</th>
                                                    <th>Estoque</th>
                                                    <th>Compra</th>
                                                    <th>Baixa</th>
                                                    <th>Tipo</th>
                                                    <th>Dt. Reposição</th>
                                                    <th>Dt. Baixa</th>
                                                    <th>Modelo</th>
                                                    <th>Fornecedor</th>
                                                    <th>Valor Unitário</th>
                                                    <th>Valor Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($produtos->count())
                                                    @foreach ($produtos as $produto)
                                                        @php
                                                            $fornecedor = App\Models\Fornecedores::find(
                                                                $produto->fornecedor,
                                                            );
                                                            $totalEstoque += $produto->estoque;
                                                            $totalCompra += $produto->compra;
                                                            $totalBaixa += $produto->baixa;
                                                            $totalValorUnitario += $produto->valor_unitario;
                                                            $totalValorTotal += $produto->valor_total;
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $produto->referencia }}</td>
                                                            <td class="{{ $produto->estoque <= 0 ? 'estoque-vermelho' : 'estoque-verde' }}">
                                                                <i class="{{ $produto->estoque <= 0 ? 'fas fa-warning' : 'fas fa-check' }}" style="margin-right: 2px;"></i>
                                                                <b>{{ number_format($produto->estoque, 0) }}</b>
                                                            </td>
                                                            </td>
                                                            <td><b>{{ number_format($produto->compra, 0, '.', '.') }}</b>
                                                            </td>
                                                            <td><b>{{ number_format($produto->baixa, 0, '.', '.') }}</b>
                                                            </td>
                                                            <td>
                                                                @if ($produto->baixa == 0)
                                                                    <b class="status-compra">Compra</b>
                                                                @endif  
                                                                @if ($produto->compra == 0)   
                                                                    <b class="status-venda">Venda</b>
                                                                @endif    
                                                            </td>
                                                            <td>{{ \Carbon\Carbon::parse($produto->data_reposicao)->format('d/m/Y') }}
                                                            </td>
                                                            <td>{{ \Carbon\Carbon::parse($produto->data_baixa)->format('d/m/Y') }}
                                                            </td>
                                                            <td>{{ $produto->modelo }}</td>
                                                            <td>{{ $fornecedor->razao_social ?? 'N/A' }}</td>
                                                            <td>R$
                                                                {{ number_format($produto->valor_unitario, 4, ',', '.') }}
                                                            </td>
                                                            <td>R$ {{ number_format($produto->valor_total, 2, ',', '.') }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="10" class="text-center">Nenhum registro encontrado
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Qtd. Total</th>
                                                    <th></th>
                                                    <th>{{ number_format($totalCompra, 0, '.', '.') }}</th>
                                                    <th>{{ number_format($totalBaixa, 0, '.', '.') }}</th>
                                                    <th colspan="5"></th>
                                                    <th>{{ number_format($totalValorUnitario, 4, ',', '.') }}</th>
                                                    <th>{{ number_format($totalValorTotal, 2, ',', '.') }}</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <div class="d-flex justify-content-center mt-3">
                                            {{ $produtos->links() }}
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Modal Sintético -->
                        <div class="modal fade" id="modal-sintetico" tabindex="-1" aria-labelledby="modalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel">Relatório Sintético</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Fornecedor</th>
                                                        <th>Estoque</th>
                                                        <th>Compra</th>
                                                        <th>Baixa</th>
                                                        <th>Valor Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $groupedFornecedores = $produtos->groupBy('fornecedor');
                                                    @endphp
                                                    @foreach ($groupedFornecedores as $fornecedorId => $produtosFornecedor)
                                                        @php
                                                            $fornecedor = App\Models\Fornecedores::find($fornecedorId);
                                                            $totalFornecedorEstoque = $produtosFornecedor->sum(
                                                                'estoque',
                                                            );
                                                            $totalFornecedorCompra = $produtosFornecedor->sum('compra');
                                                            $totalFornecedorBaixa = $produtosFornecedor->sum('baixa');
                                                            $totalFornecedorValor = $produtosFornecedor->sum(
                                                                'valor_total',
                                                            );
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $fornecedor->razao_social ?? 'N/A' }}</td>
                                                            <td>{{ number_format($totalFornecedorEstoque, 0, '.', '.') }}
                                                            </td>
                                                            <td>{{ number_format($totalFornecedorCompra, 0, '.', '.') }}
                                                            </td>
                                                            <td>{{ number_format($totalFornecedorBaixa, 0, '.', '.') }}
                                                            </td>
                                                            <td>R$ {{ number_format($totalFornecedorValor, 2, ',', '.') }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Fechar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fim do Modal Sintético -->
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
