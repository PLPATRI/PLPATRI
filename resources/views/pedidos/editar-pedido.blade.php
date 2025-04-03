@section('title', 'Editar Pedido - Combrim')

@extends('components.main')
@section('content')
    <div class="content-wrapper">
        <div class="container-full"> 
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xxl-12">
                        <div class="row">
                            <div class="col-12">
                                <div class="box">
                                    <div class="box-header">
                                        <h4 class="box-title fw-600">Editar Pedido</h4>
                                    </div>
                                    <div class="box-header">
                                        <div class="row justify-content-between">
                                            <div class="col-lg-8 col-sm-12 col-md-6">
                                                <div class="row">
                                                    <div class="d-flex align-items-center gap-10">
                                                        <h3 class="me-3">Pedido #{{ $pedido->id }}</h3>
                                                        @if ($pedido->status == 'pronto')
                                                            <span class="badge badge-success">Pronto</span>
                                                        @elseif ($pedido->status == 'nao pronto')
                                                            <span class="badge badge-danger">Não Pronto</span>
                                                        @endif
                                                    </div>
                                                    <div class="col-6">
                                                        <h5>Nome ou Razão Social: {{ $pedido->cliente->nome }}</h5>
                                                        <h5>CPF/CNPJ: {{ $pedido->cpf_cnpj }}</h5>
                                                        <h5>Telefone: {{ $pedido->cliente->telefone }}</h5>
                                                        <h5>Email: {{ $pedido->cliente->email }}</h5>
                                                    </div>
                                                    <div class="col-6">
                                                        <h5>Endereço: {{ $pedido->cliente->endereco }},
                                                            {{ $pedido->cliente->numero }} -
                                                            {{ $pedido->cliente->cidade }}/{{ $pedido->cliente->uf }}</h5>
                                                        <h5>CEP: {{ $pedido->cliente->cep }}</h5>
                                                        <h5>Bairro: {{ $pedido->cliente->bairro }} </h5>
                                                        <h5>Vendedor:
                                                            @if ($pedido->vendedor !== null)
                                                                {{ $pedido->vendedor->usuario }}
                                                            @else
                                                                Admin
                                                            @endif
                                                        </h5>
                                                        @if ($pedido->balcao == 1)
                                                            <h5>Retirada: Balcão</h5>
                                                        @else
                                                            <h5>Entrega em {{ $pedido->endereco }},
                                                                {{ $pedido->numero }}</h5>
                                                        @endif
                                                    </div>
                                                    <h5>Observações: {{ $pedido->observacoes }}</h5>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="d-flex justify-content-between">
                                                    @if ($pedido->status == 'nao pronto')
                                                        <form
                                                            action="{{ route('pedido.update', ['pedido' => $pedido->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('POST')
                                                            <input type="hidden" name="id_pedido"
                                                                value="{{ $pedido->id }}" />
                                                            <input type="hidden" name="status" value="pronto">
                                                            <button type="submit" class="btn btn-success">
                                                                <i class="fas fa-check"></i> Pedido Pronto
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form
                                                            action="{{ route('pedido.update', ['pedido' => $pedido->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('POST')
                                                            <input type="hidden" name="id_pedido"
                                                                value="{{ $pedido->id }}" />
                                                            <input type="hidden" name="status" value="nao pronto">
                                                            <button type="submit" class="btn btn-danger">
                                                                <i class="fas fa-times"></i> Pedido Não Pronto
                                                            </button>
                                                        </form>
                                                    @endif
                                                    @if ($pedido->financeiro == 'deve')
                                                        <form
                                                            action="{{ route('pedido.financeiro', ['pedido' => $pedido->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('POST')
                                                            <input type="hidden" name="id_pedido"
                                                                value="{{ $pedido->id }}" />
                                                            <input type="hidden" name="financeiro" value="pago">
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="fas fa-dollar"></i> Pedido Pago
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form
                                                            action="{{ route('pedido.financeiro', ['pedido' => $pedido->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('POST')
                                                            <input type="hidden" name="id_pedido"
                                                                value="{{ $pedido->id }}" />
                                                            <input type="hidden" name="financeiro" value="deve">
                                                            <button type="submit" class="btn btn-danger">
                                                                <i class="fas fa-dollar"></i> Pedido Não Pago
                                                            </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex p-20 justify-content-between">
                                        <form action="{{ route('editar.pedido.get', ['id' => $pedido->id]) }}"
                                            method="GET" class="d-flex p-20 justify-content-between" style="width: 100%">
                                            <div class="form-group d-flex align-items-center mb-15">
                                                <label>Referência:</label>
                                                <input type="text"
                                                    class="form-control w-75 ms-10"  value="{{ request('referencia_de') }}" name="referencia_de" placeholder="Referência de">
                                                <input type="text" 
                                                    class="form-control w-75 mx-10" name="referencia_ate" value="{{ request('referencia_ate') }}" placeholder="Referencia até">
                                                <button class="btn btn-primary-light btn-sm"
                                                    wire:click="atualizarProdutos"><i
                                                        class="fas fa-search"></i></button>
                                            </div>
                                            <div class="form-group d-flex align-items-center mb-15">
                                                <label>Modelo:</label>
                                                <input type="text" name="modelo" value="{{ request('modelo') }}"
                                                    class="form-control w-75 mx-10" placeholder="1">
                                                <button type="submit" class="btn btn-primary-light btn-sm"><i
                                                        class="fas fa-search"></i></button>
                                            </div>
                                            <div class="form-group d-flex align-items-center mb-15">
                                                <label>Fornecedor:</label>
                                                <input type="text" name="fornecedor" value="{{ request('fornecedor') }}"
                                                    class="form-control w-75 mx-10" placeholder="1">
                                                <button type="submit" class="btn btn-primary-light btn-sm"><i
                                                        class="fas fa-search"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                    <form action="{{ route('pedido.validar') }}" method="post">
                                        @csrf
                                        @method('POST')
                                        <div class="box-body">
                                            <div class="table-responsive">
                                                <table id="example1" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Referência</th>
                                                            <th>Quantidade</th>
                                                            <th>Modelo</th>
                                                            <th>Fornecedor</th>
                                                            <th>Falta</th>
                                                            <th>Status</th>
                                                            <th>Valor Unitário</th>
                                                            <th>Valor Total</th>
                                                            <th>Deletar</th>
                                                            {{-- <th>Salvar</th> --}}
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($pedido->items as $item)
                                                            <tr>
                                                                <td>
                                                                    {{ $item->produto->referencia }}
                                                                </td>
                                                                <td class="w-50">
                                                                    <div class="form-group">
                                                                        <input type="text"
                                                                            name="quantidade[{{ $item->id }}]"
                                                                            value="{{ $item->quantidade }}"
                                                                            data-item-id="{{ $item->id }}"
                                                                            class="form-control" placeholder="">
                                                                    </div>
                                                                </td>
                                                                <td>{{ $item->modelo }}</td>
                                                                <td>
                                                                    {{ $item->produto->fornecedor->razao_social }}
                                                                </td>
                                                                @php
                                                                    $produto = App\Models\Produtos::find(
                                                                        $item->produto_id,
                                                                    );
                                                                    $estoque = $produto->quantidade;

                                                                    if ($estoque < 0) {
                                                                        $quantidadeFaltando =
                                                                            $item->quantidade + $estoque;
                                                                    } else {
                                                                        $quantidadeFaltando = max(
                                                                            0,
                                                                            $item->quantidade - $estoque,
                                                                        );
                                                                    }
                                                                @endphp
                                                                @if ($quantidadeFaltando < 0)
                                                                    <td style="color:rgb(255, 0, 0);">
                                                                        <i class="fas fa-warning"
                                                                            style="margin-right: 10px;"></i>
                                                                        <b>{{ $quantidadeFaltando }}</b>
                                                                    </td>
                                                                    <td>
                                                                        <div style="color:rgb(255, 0, 0); font-size: 25px;"
                                                                            class="icon-alert-animation">
                                                                            <i class="fas fa-warning"
                                                                                style="margin-right: 10px;"></i>
                                                                        </div>
                                                                    </td>
                                                                @else
                                                                    <td><b>{{ $quantidadeFaltando }}</b></td>
                                                                    <td>
                                                                        <div
                                                                            style="color:rgb(5, 150, 7); font-size: 25px;">
                                                                            <i class="fas fa-check"
                                                                                style="margin-right: 10px;"></i>
                                                                        </div>
                                                                    </td>
                                                                @endif
                                                                <td><b>R$
                                                                        {{ number_format($item->valor_unitario, 4, ',', '.') }}</b>
                                                                </td>
                                                                <td><b>R$
                                                                        {{ number_format($item->valor_total, 2, ',', '.') }}</b>
                                                                </td>
                                                                <td>
                                                                    <form action="{{ route('pedido.item.delete') }}"
                                                                        method="post">
                                                                        @csrf
                                                                        @method('POST')
                                                                        <input type="hidden" name="id_item"
                                                                            value="{{ $item->id }}" />
                                                                        <input type="hidden" name="id_pedido"
                                                                            value="{{ $pedido->id }}" />
                                                                        <button type="submit"
                                                                            class="btn btn-danger-light btn-sm"><i
                                                                                class="fas fa-trash"
                                                                                style="color: red; font-size: 20px;"></i></button>
                                                                    </form>
                                                                </td>
                                                                {{-- <td>
                                                                    <a class="mx-10" href="#"><i
                                                                            class="fas fa-save"
                                                                            style="color: green; font-size: 20px;"></i></a>
                                                                </td> --}}
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <p><strong>Produtos Selecionados:</strong> {{ $pedido->numero_produtos }} produto(s)</p>
                                            <div class="row justify-content-between align-items-center">
                                                <div class="col-6">
                                                    <form action="{{ route('pedido.salvar.observacao', ['pedidoId' => $pedido->id]) }}" method="POST"> {{-- Rota Exemplo --}}
                                                        @csrf
                                                        <div class="form-group mt-10">
                                                            <label>Observações</label>
                                                            <div class="d-flex align-items-center">
                                                                <textarea class="form-control"
                                                                        name="observacao"  {{-- Nome do campo --}}
                                                                        placeholder="Digite suas observações aqui...">{{ old('observacao', $pedido->observacoes) }}</textarea> {{-- Exibe valor atual --}}
                                                                <button type="submit" class="btn btn-sm btn-success mx-10">
                                                                    <i class="fas fa-check"></i> Confirmar
                                                                </button>
                                                            </div>
                                                            @error('observacao') {{-- Exibe erro de validação --}}
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </form>
                                                </div>
                                                <!--<div class="col-5">
                                                    <div class="form-group mt-10">
                                                        <label>Desconto (R$)</label>
                                                        <div class="d-flex align-items-center">
                                                            <div class="input-group">
                                                                <input 
                                                                    type="number" 
                                                                    class="form-control" 
                                                                    id="desconto"
                                                                    wire:model.defer="desconto" 
                                                                    min="0" 
                                                                    step="0.01"
                                                                    placeholder="0.00">
                                                                <div class="input-group-append ms-10">
                                                                    <button 
                                                                        class="btn btn-primary" 
                                                                        type="button" 
                                                                        wire:click="salvarDesconto({{ $pedido->id }})"
                                                                        wire:loading.attr="disabled">
                                                                        <span wire:loading wire:target="salvarDesconto">
                                                                            <i class="fas fa-spinner fa-spin"></i>
                                                                        </span>
                                                                        <span wire:loading.remove wire:target="salvarDesconto">
                                                                            Aplicar
                                                                        </span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @error('desconto') 
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>                                                                           -->
                                                <!-- Total e Desconto -->
                                                <div class="col-3">
                                                    <div class="d-flex flex-column align-items-end my-10">
                                                        @php
                                                            $valorBruto = $pedido->valor_bruto ?? ($pedido->desconto > 0 ? $pedido->valor / (1 - $pedido->desconto / 100) : $pedido->valor);
                                                            $valorBruto = $valorBruto ?? 0; // Garante que não é null
                                                        @endphp
                                                        <h5 id="valor-bruto-display"> {{-- ID para fácil acesso --}}
                                                            Valor Bruto:
                                                            
                                                            <b data-valor-bruto="{{ $valorBruto }}">
                                                                R$ {{ number_format($valorBruto, 2, ',', '.') }}
                                                            </b>
                                                        </h5>

                                                        @if ($pedido->desconto > 0)
                                                            <h5 class="text-danger">
                                                                Desconto:
                                                                {{-- Guarda o percentual numérico em um data attribute --}}
                                                                <b data-desconto="{{ $pedido->desconto }}">
                                                                    {{ $pedido->desconto }}%
                                                                </b>
                                                            </h5>
                                                            <h4 class="mt-10">
                                                                Valor Final:
                                                                {{-- ID para colocar o valor calculado pelo JS --}}
                                                                <b id="valor-final-calculado">
                                                                    {{-- Pode deixar o valor inicial do servidor ou deixar vazio --}}
                                                                    R$ {{ number_format($pedido->valor, 2, ',', '.') }}
                                                                </b>
                                                            </h4>
                                                            {{-- <h6 class="text-dark mt-10">Prazo para pagamento: À vista</h6> --}}
                                                        @else
                                                            <h4 class="mt-10">
                                                                Valor Final:
                                                                {{-- ID aqui também para consistência, embora não haja cálculo --}}
                                                                <b id="valor-final-calculado">
                                                                    R$ {{ number_format($pedido->valor, 2, ',', '.') }}
                                                                </b>
                                                            </h4>
                                                            <span>Sem desconto aplicado</span>
                                                            {{-- <h6 class="text-dark mt-10">Prazo para pagamento: 30 dias</h6> --}}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row px-20 pb-10">
                                            <div class="col-12">
                                                <button class="btn btn-success" type="button" data-bs-toggle="modal"
                                                    data-bs-target=".add-item-modal" style="width: 100%"><i
                                                        class="fas fa-plus" style="margin-right: 5px;"></i> Adicionar
                                                    Produto </a>
                                            </div>
                                        </div>
                                        <div class="box-footer d-flex justify-content-between">
                                            <form action="{{ route('pedido.delete') }}" method="post">
                                                @csrf
                                                @method('POST')
                                                <input type="hidden" name="id_pedido" value="{{ $pedido->id }}" />
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-trash" style="margin-right: 5px;"></i> Excluir Pedido
                                                </button>
                                            </form>
                                            <form action="{{ route('pdf.pedido.post') }}" method="post">
                                                @csrf
                                                @method('POST')
                                                <input type="hidden" name="id_pedido" value="{{ $pedido->id }}" />
                                                <button type="submit" class="btn btn-secondary">
                                                    <i class="fas fa-print"></i> Imprimir PDF
                                                </button>
                                            </form>
                                            <input type="hidden" name="id_pedido" value="{{ $pedido->id }}" />
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-check"></i> Validar Pedido
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
    </div>

    <!-- /.modal produtos -->
    @livewire('pedidos.modal-editar-pedido', ['pedido' => $pedido])
    <script>
        $(document).ready(function() {
            $('.atualizar-quantidade').click(function() {
                const itemId = $(this).data('item-id');
                const quantidade = $(this).closest('tr').find('.quantidade-input').val();
                
                $.ajax({
                    url: `/pedidos/item/${itemId}/quantidade`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        quantidade: quantidade
                    },
                    success: function(response) {
                        toastr.success('Quantidade atualizada com sucesso');
                        location.reload();
                    },
                    error: function() {
                        toastr.error('Erro ao atualizar quantidade');
                    }
                });
            });
        });
    </script>
    <script>
        const resumoPedidoDiv = document.querySelector('.resumo-pedido');
        const editarPedidoDiv = document.querySelector('.editar-pedido');
        const editarPedidoBtn = document.getElementById('editar-pedido-btn');
        const salvarPedidoBtn = document.getElementById('salvar-pedido-btn');

        editarPedidoBtn.addEventListener('click', function() {
            // Mostrar newCustomerDiv e esconder customerDiv
            editarPedidoDiv.classList.remove('hidden');
            resumoPedidoDiv.classList.add('hidden');

        });

        salvarPedidoBtn.addEventListener('click', function() {
            // Mostrar newCustomerDiv e esconder customerDiv
            resumoPedidoDiv.classList.remove('hidden');
            editarPedidoDiv.classList.add('hidden');

        });
    </script>

    <script>
        document.getElementById('entrega').addEventListener('click', function() {
            var enderecoInput = document.getElementById('endereco');
            enderecoInput.classList.remove('hidden'); // Remove  a classe hidden para exibir o input
        });

        document.getElementById('balcao').addEventListener('click', function() {
            var balcaoInput = document.getElementById('balcao');
            var enderecoInput = document.getElementById('endereco');
            enderecoInput.classList.add('hidden'); // Remove a classe hidden para exibir o input
        });
    </script>



    <!-- Vendor JS -->
    <script src="{{ asset('js/vendors.min.js') }}"></script>
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
    <script src="{{ asset('js/jquery.smartmenus.js') }}"></script>
    <script src="{{ asset('js/menus.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
    <script src="{{ asset('js/pages/dashboard2.js') }}"></script>
    <script src="{{ asset('js/pages/calendar.js') }}"></script>

    <script>
    // Espera o DOM (a página HTML) carregar completamente
    document.addEventListener('DOMContentLoaded', function() {

        // Função para calcular e atualizar o valor final
        function calcularValorFinalComDesconto() {
            // Pega os elementos pelos seus atributos/IDs
            const valorBrutoElement = document.querySelector('[data-valor-bruto]');
            const descontoElement = document.querySelector('[data-desconto]');
            const valorFinalElement = document.getElementById('valor-final-calculado');

            // Verifica se os elementos essenciais existem
            if (!valorBrutoElement || !valorFinalElement) {
                console.error("Elementos necessários para cálculo não encontrados (valor bruto ou valor final).");
                return; // Sai da função se não encontrar
            }

            // Pega os valores numéricos dos atributos 'data-*'
            // parseFloat converte a string do atributo em número decimal
            const valorBruto = parseFloat(valorBrutoElement.getAttribute('data-valor-bruto'));
            let descontoPercentual = 0; // Assume 0 se não houver desconto

            // Só pega o desconto se o elemento existir (caso de $pedido->desconto ser 0)
            if (descontoElement) {
                descontoPercentual = parseFloat(descontoElement.getAttribute('data-desconto'));
            }

            // Valida se os valores são números válidos
            if (isNaN(valorBruto) || isNaN(descontoPercentual)) {
                console.error("Valor bruto ou desconto inválido.");
                valorFinalElement.textContent = 'Erro'; // Informa um erro na tela
                return;
            }

            let valorFinalCalculado;

            // Calcula o valor final APENAS se houver desconto
            if (descontoPercentual > 0) {
                const valorDoDesconto = valorBruto * (descontoPercentual / 100);
                valorFinalCalculado = valorBruto - valorDoDesconto;
            } else {
                // Se não há desconto, o valor final é igual ao bruto
                valorFinalCalculado = valorBruto;
            }

            // Formata o valor final como moeda brasileira (R$ 1.234,56)
            const valorFormatado = valorFinalCalculado.toLocaleString('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            });

            // Atualiza o texto do elemento <b> do Valor Final
            valorFinalElement.textContent = valorFormatado;
        }

        // Chama a função para fazer o cálculo assim que a página carregar
        calcularValorFinalComDesconto();

    }); // Fim do addEventListener('DOMContentLoaded')
</script>
@endsection
