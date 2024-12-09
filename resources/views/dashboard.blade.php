@extends('components.main')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="min-height: 1487px;">
        <div class="container-full">
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xxl-12">
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                                <div class="box pull-up">
                                    <div class="first-section">
                                        <div class="d-flex align-items-center justify-content-between first-plan">
                                            <div>
                                                <p class="text-mute mb-0">Valor do estoque</p>
                                                <h3 class="text-dark mb-0 mt-1 fw-500">R$
                                                    {{ number_format($data['valorTotalEstoque'], 2, ',', '.') }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                                <div class="box pull-up">
                                    <div class="first-section">
                                        <div class="d-flex align-items-center justify-content-between first-plan">
                                            <div>
                                                <p class="text-mute mb-0">Produtos no estoque</p>
                                                <h3 class="text-dark mb-0 mt-1 fw-500">{{ $data['totalProdutos'] }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                                <div class="box pull-up">
                                    <div class="first-section">
                                        <div class="d-flex align-items-center justify-content-between first-plan">
                                            <div>
                                                <p class="text-mute mb-0">Clientes</p>
                                                <h3 class="text-dark mb-0 mt-1 fw-500">{{ $data['totalClientes'] }}
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (!auth()->guard('vendedor'))
                                <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                                    <div class="box pull-up">
                                        <div class="first-section">
                                            <div class="d-flex align-items-center justify-content-between first-plan">
                                                <div>
                                                    <p class="text-mute mb-0">Vendas no mês</p>
                                                    <h3 class="text-dark mb-0 mt-1 fw-500">R$
                                                        {{ number_format($data['totalVendasNoMes'], 2, ',', '.') }}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-xxl-12 col-lg-12 col-12">
                                <div class="box">
                                    <div class="d-flex justify-content-between box-header">
                                        <h4 class="box-title fw-600">Últimas Vendas</h4>
                                    </div>
                                    <div class="box-body p-0">
                                        <div class="table-responsive px-2" style="margin: 0px 2px;">
                                            <table class="table table-responsive mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Nome/Razão Social</th>
                                                        <th>CPF/CNPJ</th>
                                                        <th>Telefone</th>
                                                        <th>Data</th>
                                                        <th>Valor</th>
                                                        <th>Valor com desconto</th>
                                                        {{-- <th>Ações</th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data['pedidos'] as $pedidos)
                                                        <tr class="text-fade">
                                                            <td>{{ $pedidos['razao_social'] }}</td>
                                                            <td>{{ $pedidos['cpf_cnpj'] }}</td>
                                                            <td>{{ $pedidos['telefone'] }}</td>
                                                            <td>{{ $pedidos['data'] }}</td>
                                                            <td>R$ {{ number_format($pedidos['valor'], 2, ',', '.') }}</td>
                                                            <td>
                                                                @php
                                                                    $valorComDesconto =
                                                                        ($pedidos['valor'] * $pedidos['desconto']) /
                                                                        100;
                                                                    $valorComDesconto =
                                                                        $pedidos['valor'] - $valorComDesconto;
                                                                @endphp
                                                                R$
                                                                {{ number_format($valorComDesconto, 2, ',', '.') }}
                                                            </td>
                                                            {{-- <td><a href="#"><i class="fas fa-eye"></i></a></td> --}}
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xxl-12 col-lg-12 col-12">
                                <div class="box">
                                    <div class="d-flex justify-content-between box-header">
                                        <h4 class="box-title fw-600">Últimos Carregamentos</h4>
                                    </div>
                                    <div class="box-body p-0">
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
                                                    @foreach ($data['ultimosCarregamentos'] as $ultimoCarregamento)
                                                        <tr class="text-fade">
                                                            <td>#{{ $ultimoCarregamento['id'] }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($ultimoCarregamento['data'])->format('d/m/Y') }}
                                                            </td>
                                                            <td>{{ $ultimoCarregamento['modelo'] }}</td>
                                                            <td>{{ $ultimoCarregamento['quantidade'] }}</td>
                                                            <td>R${{ number_format($ultimoCarregamento['preco_unitario'], 4, ',', '.') }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
    </div>
@endsection
