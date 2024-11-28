@section('title', 'Pedidos - Combrim')
<div>
    <div class="d-flex p-20 justify-content-between">
        <div class="form-group d-flex align-items-center mb-15">
            <label>Número Pedido:</label>
            <input type="text" class="form-control w-75 ms-10" wire:model.live="numero_pedido_incial" placeholder="1">
            <input type="text" class="form-control w-75 mx-10" wire:model.live="numero_pedido_final" placeholder="10">
        </div>

        <div class="form-group d-flex align-items-center mb-15">
            <label>Nome:</label>
            <input type="text" class="form-control w-75 mx-10" wire:model.live="razao_social"
                placeholder="Nome/Razão Social">
        </div>

        <div class="form-group d-flex align-items-center mb-15">
            <label>Mês/Ano:</label>
            <input type="date" class="form-control w-75 mx-10" wire:model.live="data_inicial" placeholder="De">
            Até
            <input type="date" class="form-control w-75 mx-10" wire:model.live="data_final" placeholder="Até">
        </div>

        <div class="form-group d-flex align-items-center mb-15">
            <label>CNPJ/CPF:</label>
            <input type="text" class="form-control w-75 mx-10" wire:model.live="numero_documento"
                placeholder="999.999.999-99">
        </div>
    </div>
    <div class="box-body p-0">
        <div class="table-responsive px-2" style="margin: 0px 2px;">
            <table class="table table-responsive mb-0">
                <thead>
                    <tr>
                        <th>Nº Pedido</th>
                        <th>Nome/Razão Social</th>
                        <th>CPF/CNPJ</th>
                        <th>Balcão</th>
                        <th>Telefone</th>
                        <th>Data</th>
                        <th>Valor</th>
                        <th>Financeiro</th>
                        <th>Status</th>
                        <th>Confirmação</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($pedidos !== null)
                        @foreach ($pedidos as $item)
                            <tr class="text-fade">
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->razao_social }}</td>
                                <td>{{ $item->cpf_cnpj }}</td>
                                @if ($item->balcao == 1)
                                    <td>Balcão</td>
                                @else
                                    <td>Entrega</td>
                                @endif
                                <td>{{ $item->telefone }}</td>
                                <td>{{ $item->data }}</td>
                                <td>R$ {{ number_format($item->valor * (1 - $item->desconto / 100), 2, ',', '.') }}</td>
                                <td>
                                    @if ($item->financeiro == 'deve')
                                        <div class="badge badge-danger">Deve</div>
                                    @else
                                        <div class="badge badge-success">Pago</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex">
                                        @if ($item->status == 'nao pronto')
                                            <div style="color:rgb(255, 0, 0); font-size: 20px;"
                                                class="icon-alert-animation">
                                                <i class="fas fa-warning"
                                                    style="margin-right: 10px; color:rgb(255, 0, 0) !important;"></i>
                                            </div>
                                            <div class="badge badge-danger">Não Pronto</div>
                                        @else
                                            <div style="color:green; font-size: 20px;" class="icon-alert-animation">
                                                <i class="fas fa-check" style="margin-right: 10px;"></i>
                                            </div>
                                            <div class="badge badge-success">Pronto</div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if ($item->confirmacao == 'Ag Estoque')
                                        <div class="badge badge-primary">Ag. Estoque</div>
                                    @endif
                                    @if ($item->confirmacao == 'Ag Confirmacao')
                                        <div class="badge badge-primary">Ag. Confirmação</div>
                                    @endif
                                    @if ($item->confirmacao == 'Confirmado')
                                        <div class="badge badge-success">Confirmado</div>
                                    @endif
                                </td>
                                <td class="">
                                    <a data-bs-toggle="modal" wire:click="editarPedido({{ $item->id }})"
                                        data-bs-target=".pedido-view-modal" href="#"><i
                                            class="fas fa-eye"></i></a>
                                    <a href="{{ route('editar.pedido.get', $item->id) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif

                </tbody>
            </table>
            <div class="d-flex justify-content-center" style="padding: 20px 0">
                {{ $pedidos->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Check Pedido -->
    <div class="modal fade pedido-check-modal" wire:ignore.self tabindex="-1" role="dialog"
        aria-labelledby="pedidoCheckModal" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                @isset($pedidoSelecionado)
                    <div class="resumo-pedido">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Resumo do Pedido</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <div class="row justify-content-between">
                                        <div class="col-12 header-pedido">
                                            <h4 class="mb-0">Data:
                                                {{ \Carbon\Carbon::parse($pedidoSelecionado->data)->format('d/m/y') }}</h4>
                                            <img class="img-fluid" src="imgs/logo.jpg" style="width: 150px">
                                            <h4 class="mb-0">Pedido #{{ $pedidoSelecionado->id }}</h4>
                                        </div>

                                        <div class="col-lg-6 col-sm-12 col-md-6">
                                            <div class="row">
                                                <div class="col-6">
                                                    <h4><b>Cliente: {{ $pedidoSelecionado->razao_social }}</b></h4>
                                                    <h5>CPF/CNPJ: {{ $pedidoSelecionado->cpf_cnpj }}</h5>
                                                    <h5>Telefone: {{ $pedidoSelecionado->telefone }}</h5>
                                                    <h5>Email: {{ $cliente->email }}</h5>
                                                </div>
                                                <div class="col-6">
                                                    <h5>Endereço: {{ $cliente->endereco }}, {{ $cliente->numero }} -
                                                        {{ $cliente->cidade }}/{{ $cliente->uf }} </h5>
                                                    <h5>CEP: {{ $cliente->cep }}</h5>
                                                    <h5>Bairro: {{ $cliente->bairro }}</h5>
                                                    <h5>Vendedor:
                                                        @if ($vendedor !== null)
                                                            {{ $vendedor->usuario }}
                                                        @else
                                                            Admin
                                                        @endif
                                                    </h5>
                                                    @if ($pedidoSelecionado->balcao == 1)
                                                        <h5>Retirada: Balcão</h5>
                                                    @else
                                                        <h5>Entrega em {{ $pedidoSelecionado->endereco }},
                                                            {{ $pedidoSelecionado->numero }}</h5>
                                                    @endif
                                                </div>
                                            </div>
                                            <h5>Observações: {{ $pedidoSelecionado->observacoes }}</h5>
                                        </div>
                                        <div class="col-lg-4 col-sm-12 col-md-6">
                                            <button wire:click="pedidoPronto({{ $pedidoSelecionado->id }})" type="button"
                                                class="btn btn-success">
                                                <i class="fas fa-check"></i> Pedido Pronto
                                            </button>
                                            <button wire:click="pedidoPago({{ $pedidoSelecionado->id }})" type="button"
                                                class="btn btn-primary">
                                                <i class="fas fa-dollar"></i> Pedido Pago
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Tabela de Itens -->
                                    <div class="table-responsive" style="max-height: 400px">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Referência</th>
                                                    <th>Modelo</th>
                                                    <th>Quantidade</th>
                                                    <th>Falta</th>
                                                    <th>Valor Unitário</th>
                                                    <th>Valor Total</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pedidoSelecionado->items as $item)
                                                    <tr>
                                                        <td>{{ $item->produto->referencia }}</td>
                                                        <td>{{ $item->modelo }}</td>
                                                        <td>{{ $item->quantidade }}</td>
                                                        <td>
                                                            @php
                                                                $produto = App\Models\Produtos::find($item->produto_id);
                                                                $estoque = $produto->quantidade;

                                                                if ($estoque < 0) {
                                                                    $quantidadeFaltando = $item->quantidade + $estoque;
                                                                } else {
                                                                    $quantidadeFaltando = max(
                                                                        0,
                                                                        $item->quantidade - $estoque,
                                                                    );
                                                                }
                                                            @endphp
                                                            @if ($quantidadeFaltando < 0)
                                                                <b class="text-danger">{{ $quantidadeFaltando }}</b>
                                                            @else
                                                                <b>{{ $quantidadeFaltando }}</b>
                                                            @endif

                                                        </td>
                                                        <td><b>R$
                                                                {{ number_format($item->valor_unitario, 4, ',', '.') }}</b>
                                                        </td>
                                                        <td><b>R$ {{ number_format($item->valor_total, 2, ',', '.') }}</b>
                                                        </td>
                                                        <td><a data-bs-toggle="modal"
                                                                wire:click="deletarItemPedido({{ $item['id'] }}, {{ $pedidoSelecionado->id }}, {{ $item->valor_total }})"
                                                                href="#"><i class="fas fa-trash"></i></a></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Formulário para Ajustes -->
                                    <div class="row justify-content-between">
                                        <div class="col-lg-3 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label>Desconto (%)</label>
                                                <div class="d-flex">
                                                    <input type="number" id="desconto" class="form-control"
                                                        placeholder="%"
                                                        wire:model="descontoPedido.{{ $pedidoSelecionado->id }}"
                                                        value="{{ $pedidoSelecionado->desconto }}"
                                                        oninput="limitarDesconto(this)"
                                                        onkeypress="return apenasNumeros(event)">
                                                    <button wire:click="aplicarDesconto({{ $pedidoSelecionado->id }})"
                                                        class="btn btn-sm btn-success mx-10">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-lg-3 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label>Ajustar valor</label>
                                                <div class="d-flex">
                                                    <input type="text" id="desconto" class="form-control"
                                                        placeholder="R$"
                                                        wire:model="valorPedido.{{ $pedidoSelecionado->id }}"
                                                        value="{{ $pedidoSelecionado->valor }}"
                                                        oninput="formatarValor(this)"
                                                        onkeypress="return apenasNumeros(event)">
                                                    <button wire:click="ajustarValor({{ $pedidoSelecionado->id }})"
                                                        class="btn btn-sm btn-success mx-10"><i
                                                            class="fas fa-check"></i></button>
                                                </div>
                                            </div>
                                        </div>

                                        <script>
                                            function apenasNumeros(event) {
                                                var key = event.keyCode || event.which;
                                                var tecla = String.fromCharCode(key);
                                                var regex = /[0-9]/;
                                                if (!regex.test(tecla)) {
                                                    event.preventDefault();
                                                }
                                            }

                                            function limitarDesconto(input) {
                                                var value = parseFloat(input.value);
                                                if (value < 0) {
                                                    input.value = 0;
                                                } else if (value > 100) {
                                                    input.value = 100;
                                                }
                                            }

                                            function formatarValor(input) {
                                                let value = input.value.replace(/[^\d,]/g, '');
                                                value = value.replace(',', '.');
                                                if (value !== '') {
                                                    let numero = parseFloat(value);
                                                    if (!isNaN(numero)) {
                                                        numero = numero.toFixed(2);
                                                        input.value = 'R$ ' + numero.replace('.', ',');
                                                    }
                                                }
                                            }
                                        </script>

                                        <div class="col-lg-6 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label>Observações</label>
                                                <div class="d-flex">
                                                    <input type="text" class="form-control"
                                                        wire:model="observacao.{{ $pedidoSelecionado->id }}"
                                                        placeholder="Digite a observação" /><br>
                                                    <button class="btn btn-sm btn-success mx-10"
                                                        wire:click="addObservacoes({{ $pedidoSelecionado->id }})">
                                                        <i class="fas fa-check"></i> Confirmar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Total e Desconto -->
                                    <div class="d-flex flex-column align-items-end my-10">
                                        <h5>Total: R$ {{ number_format($pedidoSelecionado->valor, 2, ',', '.') }}</h5>
                                        <h4 class="text-danger mt-10">Total com desconto: <b>R$
                                                {{ number_format($pedidoSelecionado->valor * (1 - $pedidoSelecionado->desconto / 100), 2, ',', '.') }}</b>
                                        </h4>
                                        <span>{{ number_format($pedidoSelecionado->desconto, 2, ',', '.') }}% de
                                            desconto</span>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="modal-footer d-flex justify-content-between my-30">
                            <button type="button" class="btn btn-danger"
                                wire:click="excluirPedido({{ $pedidoSelecionado->id }})">
                                <i class="fas fa-trash"></i> Excluir Pedido
                            </button>
                            <button type="button" id="editar-pedido-btn" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#editarPedidoModal">
                                <i class="fas fa-edit"></i> Editar Pedido
                            </button>

                            <form action="{{ route('pdf.pedido.post') }}" method="post">
                                @csrf
                                @method('POST')
                                <input type="hidden" name="id_pedido" value="{{ $pedidoSelecionado->id }}" />
                                <button type="submit" class="btn btn-secondary">
                                    <i class="fas fa-print"></i> Imprimir PDF
                                </button>
                            </form>
                            <button wire:click="validarPedido({{ $pedidoSelecionado->id }})" type="button"
                                class="btn btn-success">
                                <i class="fas fa-check"></i> Validar Pedido
                            </button>
                        </div>

                    </div>
                @else
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Carregando informações do pedido...</span>
                        </div>
                    </div>
                @endisset
            </div>
        </div>
    </div>

    <div class="modal fade" id="editarPedidoModal" wire:ignore.self tabindex="-1"
        aria-labelledby="editarPedidoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            @isset($pedidoSelecionado)
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarPedidoModalLabel">Editar Pedido</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-between">
                            <div class="form-group d-flex align-items-center mb-15">
                                <label>Referência:</label>
                                <input type="text" class="form-control w-75 mx-10" placeholder="1">
                                <button class="btn btn-primary-light btn-sm"><i class="fas fa-search"></i></button>
                            </div>
                            <div class="form-group d-flex align-items-center mb-15">
                                <label>Modelo:</label>
                                <input type="text" class="form-control w-75 mx-10" placeholder="1">
                                <button class="btn btn-primary-light btn-sm"><i class="fas fa-search"></i></button>
                            </div>
                            <div class="form-group d-flex align-items-center mb-15">
                                <label>Fornecedor:</label>
                                <input type="text" class="form-control w-75 mx-10" placeholder="1">
                                <button class="btn btn-primary-light btn-sm"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>

                                        <th>ID</th>
                                        <th>Quantidade</th>
                                        <th>Modelo</th>
                                        <th>Movimentação</th>
                                        <th>Status</th>
                                        <th>Valor Unitário</th>
                                        <th>Valor Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pedidoSelecionado->items as $item)
                                        <tr class="text-center">

                                            <td>{{ $item->id }}</td>
                                            <td class="w-50">
                                                <div class="form-group">
                                                    <input type="number"
                                                        wire:model="alterarPedidoSelecionadoItems.{{ $item->id }}"
                                                        class="form-control" value="{{ $item->quantidade }}"
                                                        min="1">
                                                </div>
                                            </td>
                                            <td>{{ $item->modelo }}</td>
                                            @php
                                                $movimentacao = \App\Models\Produtos::where(
                                                    'id',
                                                    $item->produto_id,
                                                )->first();
                                            @endphp
                                            @if ($movimentacao->quantidade < 0)
                                                <td class="text-danger">
                                                    <i class="fas fa-warning" style="margin-right: 10px;"></i>
                                                    {{ $movimentacao->quantidade }}
                                                </td>
                                                <td>
                                                    <div style="color:rgb(255, 0, 0); font-size: 25px;"
                                                        class="icon-alert-animation">
                                                        <i class="fas fa-warning" style="margin-right: 10px;"></i>
                                                    </div>
                                                </td>
                                            @else
                                                <td>{{ $movimentacao->quantidade }}</td>
                                                <td>
                                                    <div style="color:rgb(5, 150, 7); font-size: 25px;">
                                                        <i class="fas fa-check" style="margin-right: 10px;"></i>
                                                    </div>
                                                </td>
                                            @endif

                                            <td><b>R$
                                                    {{ number_format($item->valor_unitario, 4, ',', '.') }}</b>
                                            </td>
                                            <td><b>R$ {{ number_format($item->valor_total, 2, ',', '.') }}</b>
                                            </td>
                                            <td>
                                                <a data-bs-toggle="modal"
                                                    wire:click="deletarItemPedido({{ $item['id'] }}, {{ $pedidoSelecionado->id }})"
                                                    href="#"><i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" wire:click="salvarAlteracoes" class="btn btn-success">Aplicar</button>
                    </div>
                </div>
            @endisset
        </div>
    </div>

    <!-- /.modal view pedido -->
    <div class="modal fade pedido-view-modal" wire:ignore.self tabindex="-1" role="dialog"
        aria-labelledby="pedidoViewModal" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="resumo-pedido">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">Resumo do Pedido</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                @isset($pedidoSelecionado)
                                    <div class="row justify-content-between">
                                        <div class="col-12 header-pedido">
                                            <h4 class="mb-0">Data:
                                                {{ \Carbon\Carbon::parse($pedidoSelecionado->data)->format('d/m/y') }}
                                            </h4>
                                            <img class="img-fluid" src="imgs/logo.jpg" style="width: 150px">
                                            <h4 class="mb-0">Pedido #{{ $pedidoSelecionado->id }}</h4>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-6">
                                                    <h4><b>Cliente: {{ $pedidoSelecionado->razao_social }}</b></h4>
                                                    <h5>CPF/CNPJ: {{ $pedidoSelecionado->cpf_cnpj }}</h5>
                                                    <h5>Telefone: {{ $pedidoSelecionado->telefone }}</h5>
                                                    <h5>Email: {{ $cliente->email }}</h5>
                                                </div>
                                                <div class="col-6">
                                                    <h5>Endereço: {{ $cliente->endereco }}, {{ $cliente->numero }} -
                                                        {{ $cliente->cidade }}/{{ $cliente->uf }} </h5>
                                                    <h5>CEP: {{ $cliente->cep }}</h5>
                                                    <h5>Bairro: {{ $cliente->bairro }}</h5>
                                                    <h5>Vendedor:
                                                        @if ($vendedor !== null)
                                                            {{ $vendedor->usuario }}
                                                        @else
                                                            Admin
                                                        @endif
                                                    </h5>
                                                    @if ($pedidoSelecionado->balcao == 1)
                                                        <h5>Retirada: Balcão</h5>
                                                    @else
                                                        <h5>Entrega em {{ $pedidoSelecionado->endereco }},
                                                            {{ $pedidoSelecionado->numero }}</h5>
                                                    @endif
                                                </div>
                                            </div>
                                            <h5>Observações: {{ $pedidoSelecionado->observacoes }}</h5>
                                        </div>
                                        {{-- <div class="col-lg-4 col-sm-12 col-md-6">
                                            <button wire:click="pedidoPronto({{ $pedidoSelecionado->id }})"
                                                type="button" class="btn btn-success">
                                                <i class="fas fa-check"></i> Pedido Pronto
                                            </button>
                                            <button wire:click="pedidoPago({{ $pedidoSelecionado->id }})" type="button"
                                                class="btn btn-primary">
                                                <i class="fas fa-dollar"></i> Pedido Pago
                                            </button>
                                        </div> --}}

                                    </div>

                                    <div class="table-responsive" style="max-height: 400px">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Referência</th>
                                                    <th>Modelo</th>
                                                    <th>Quantidade</th>
                                                    <th>Falta</th>
                                                    <th>Valor Unitário</th>
                                                    <th>Valor Total</th>
                                                    {{-- <th>Ações</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pedidoSelecionado->items as $item)
                                                    <tr>
                                                        <td>{{ $item->produto->referencia }}</td>
                                                        <td>{{ $item->modelo }}</td>
                                                        <td>{{ $item->quantidade }}</td>
                                                        <td>
                                                            @php
                                                                $produto = App\Models\Produtos::find($item->produto_id);
                                                                $estoque = $produto->quantidade;

                                                                if ($estoque < 0) {
                                                                    $quantidadeFaltando =
                                                                        $item->quantidade + abs($estoque);
                                                                    $totalQueFalta = -$quantidadeFaltando;
                                                                } else {
                                                                    $quantidadeFaltando = max(
                                                                        0,
                                                                        $item->quantidade - $estoque,
                                                                    );
                                                                    $totalQueFalta = $quantidadeFaltando;
                                                                }
                                                            @endphp
                                                            @if ($totalQueFalta < 0)
                                                                <b
                                                                    class="text-danger">{{ str_replace('-', '', $totalQueFalta) }}</b>
                                                            @else
                                                                <b>{{ $totalQueFalta }}</b>
                                                            @endif

                                                        </td>
                                                        <td><b>R$
                                                                {{ number_format($item->valor_unitario, 4, ',', '.') }}</b>
                                                        </td>
                                                        <td><b>R$ {{ number_format($item->valor_total, 2, ',', '.') }}</b>
                                                        </td>
                                                        {{-- <td><a data-bs-toggle="modal"
                                                                wire:click="deletarItemPedido({{ $item['id'] }}, {{ $pedidoSelecionado->id }})"
                                                                href="#"><i class="fas fa-trash"></i></a></td> --}}
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    {{-- <div class="row justify-content-between">
                                        <div class="col-lg-6 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label>Observações</label>
                                                <div class="d-flex">
                                                    <input style="border: none; background: transparent" type="text"
                                                        readonly class="form-control"
                                                        wire:model="observacao.{{ $pedidoSelecionado->id }}"
                                                        placeholder="Digite a observação" /><br>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="d-flex flex-column align-items-end my-10">
                                        <h5>Total: R$ {{ number_format($pedidoSelecionado->valor, 2, ',', '.') }}</h5>
                                        <h4 class="text-danger mt-10">Total com desconto: <b>R$
                                                {{ number_format($pedidoSelecionado->valor * (1 - $pedidoSelecionado->desconto / 100), 2, ',', '.') }}</b>
                                        </h4>
                                        <span>{{ number_format($pedidoSelecionado->desconto, 2, ',', '.') }}% de
                                            desconto</span>
                                    </div>
                                @else
                                    <div class="d-flex justify-content-center">
                                        <div class="spinner-border" role="status">
                                            <span class="visually-hidden">Carregando informações do pedido...</span>
                                        </div>
                                    </div>
                                @endisset
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between my-30">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fas fa-close"></i> Fechar
                        </button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- /.modal delete -->
    <div class="modal fade delete-item-modal" tabindex="-1" role="dialog" aria-labelledby="deleteItemModal"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Confirmar exclusão do Item??</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <i class="fas fa-warning" style="font-size: 50px; color:rgb(255, 196, 0);"></i>
                                <h3 class="text-center">Ao confirmar, o item será removido do pedido</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-danger me-1">
                        <i class="fas fa-close"></i> Não
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-trash"></i> Sim
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</div>
