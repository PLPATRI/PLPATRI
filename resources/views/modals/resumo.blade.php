<div class="modal fade pedido-check-modal" tabindex="-1" role="dialog" aria-labelledby="pedidoCheckModal"
    aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
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
                                                            $quantidadeFaltando = max(0, $item->quantidade - $estoque);
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
                                            <input type="number" id="desconto" class="form-control" placeholder="%"
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
                                            <input type="text" id="desconto" class="form-control" placeholder="R$"
                                                wire:model="valorPedido.{{ $pedidoSelecionado->id }}"
                                                value="{{ $pedidoSelecionado->valor }}" oninput="formatarValor(this)"
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
                                 @if ($pedidoSelecionado->desconto > 0)
                                    <div class="d-flex flex-column align-items-end my-10">
                                        <h5 class="">Valor Total: <b>R$
                                        {{ number_format($pedidoSelecionado->valor, 2, ',', '.') }}</b></h5>
                                        <h4 class="text-danger mt-10">Total à vista: <b>{{ number_format($pedidoSelecionado->valor * (1 - $pedidoSelecionado->desconto / 100), 2, ',', '.') }}</b>
                                        </h4>
                                        <span>{{ number_format($pedidoSelecionado->desconto, 2, ',', '.') }}% de
                                            desconto</span>
                                        <h6 class="text-dark mt-10">Prazo para pagamento: À vista</h6>        
                                    </div>
                                @else
                                    <div class="d-flex flex-column align-items-end my-10">
                                        <h4>Total à prazo: R${{ number_format($pedidoSelecionado->valor, 2, ',', '.') }}</h4>
                                        <span>Sem desconto</span>
                                        <h6 class="text-dark mt-10">Prazo para pagamento: 30 dias</h6>        
                                    </div>
                                @endif    
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
                    <button type="button" class="btn btn-success">
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
