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
                                                    <option value="todos" selected>
                                                        Todos
                                                    </option>
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
                                    <div class="row justify-content-center">
                                        <div class="col-4 my-15">
                                            <div class="form-group d-flex mb-0">
                                                <input type="number" class="form-control w-25" placeholder="ID Inicial"
                                                    name="filtro_um" value="{{ old('filtro_um', $filtro_um) }}">
                                                <span class="mx-2">até</span>
                                                <input type="number" class="form-control w-25" placeholder="ID Final"
                                                    name="filtro_dois" value="{{ old('filtro_dois', $filtro_dois) }}">
                                                <button type="submit" class="btn btn-primary ms-2">
                                                    <i class="fas fa-search"></i> Buscar
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-4 d-flex justify-content-center my-15">
                                            <div class="form-group d-flex mb-0">
                                                <input type="text" class="form-control w-100" placeholder="Modelo"
                                                    name="" value="">
                                                <button type="submit" class="btn btn-primary ms-2">
                                                    <i class="fas fa-search"></i> Buscar
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-4  d-flex justify-content-end my-15">
                                            <div class="form-group d-flex mb-0">
                                                <input type="text" class="form-control w-100" placeholder="Fornecedor"
                                                    name="" value="">
                                                <button type="submit" class="btn btn-primary ms-2">
                                                    <i class="fas fa-search"></i> Buscar
                                                </button>
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
                                                        <th>Estoque</th>
                                                        <th>Dt. Reposição</th>
                                                        <th>Dt. Baixa</th>
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
                                                                $totalCompra += $produto->compra;
                                                                $totalBaixa += $produto->baixa;
                                                                $totalEstoque += $produto->estoque;
                                                                $totalValorUnitario += $produto->valor_unitario;
                                                                $totalValorTotal += $produto->valor_total;
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $produto->id }}</td>
                                                                <td>{{ $produto->modelo }}</td>
                                                                <td><b>{{ number_format($produto->compra, 0) }}</b></td>
                                                                <td><b>{{ number_format($produto->baixa, 0) }}</b></td>

                                                                @if ($produto->estoque < 0)
                                                                    <td style="color:rgb(255, 0, 0);">
                                                                        <i class="fas fa-warning"
                                                                            style="margin-right: 10px;"></i>
                                                                        <b>{{ number_format($produto->estoque, 0) }}</b>
                                                                    </td>
                                                                @else
                                                                    <td style="color:green;">
                                                                        <i class="fas fa-check"
                                                                            style="margin-right: 10px;"></i>
                                                                        <b>{{ number_format($produto->estoque, 0) }}</b>
                                                                    </td>
                                                                @endif
                                                                <td>{{ \Carbon\Carbon::parse($produto->data_reposicao)->format('d/m/Y') }}
                                                                </td>
                                                                <td>{{ \Carbon\Carbon::parse($produto->data_baixa)->format('d/m/Y') }}
                                                                </td>
                                                                <td>{{ $fornecedor->razao_social ?? 'N/A' }}</td>
                                                                <td>R$
                                                                    {{ number_format($produto->valor_unitario, 4, ',', '.') }}
                                                                </td>
                                                                <td>R$
                                                                    {{ number_format($produto->valor_total, 2, ',', '.') }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="10" class="text-center">Nenhum registro
                                                                encontrado</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                                <tfoot style="background-color: #cccccc;">
                                                    <tr>
                                                        <th>Qtd. Total</th>
                                                        <th></th>
                                                        <th><b>{{ number_format($totalCompra, 0) }}</b></th>
                                                        <th><b>{{ number_format($totalBaixa, 0) }}</b></th>
                                                        <th><b>{{ number_format($totalEstoque, 0) }}</b></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th><b>R$ {{ number_format($totalValorUnitario, 4, ',', '.') }}</b>
                                                        </th>
                                                        <th><b>R$ {{ number_format($totalValorTotal, 2, ',', '.') }}</b>
                                                        </th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            @if ($produtos->count())
                                                <div class="d-flex justify-content-center">
                                                    {{ $produtos->links() }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Modal Sintético permanece inalterado -->
                        <div class="modal modal-fill fade" data-backdrop="false" id="modal-sintetico" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content box">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Relatório Sintético</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
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
                                                    @php
                                                        $fornecedores = $produtos->groupBy('fornecedor');
                                                    @endphp
                                                    @if ($fornecedores->count())
                                                        @foreach ($fornecedores as $fornecedorId => $produtosFornecedor)
                                                            @php
                                                                $fornecedor = App\Models\Fornecedores::find(
                                                                    $fornecedorId,
                                                                );
                                                                $totalEstoque = $produtosFornecedor->sum('estoque');
                                                                $totalCompra = $produtosFornecedor->sum('compra');
                                                                $totalBaixa = $produtosFornecedor->sum('baixa');
                                                                $totalValor = $produtosFornecedor->sum('valor_total');
                                                            @endphp
                                                            <tr>
                                                                <td><b>{{ number_format($totalEstoque, 0) }}</b></td>
                                                                <td><b>{{ number_format($totalCompra, 0) }}</b></td>
                                                                <td><b>{{ number_format($totalBaixa, 0) }}</b></td>
                                                                <td>{{ $fornecedor->razao_social ?? 'N/A' }}</td>
                                                                <td>R$ {{ number_format($totalValor, 2, ',', '.') }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="5" class="text-center">Nenhum registro
                                                                encontrado</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                                <tfoot style="background-color: #cccccc;">
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th>Total Geral</th>
                                                        <th>
                                                            <b>
                                                                R$
                                                                {{ number_format($produtos->sum('valor_total'), 2, ',', '.') }}
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


                        <!-- Fim do Modal Sintético -->
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
    </div>
    <!-- /.content-wrapper -->

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
