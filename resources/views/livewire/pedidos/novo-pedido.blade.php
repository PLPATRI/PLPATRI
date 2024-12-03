@section('title', 'Novo Pedido - Combrim')

<div wire:ignore.self>
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xxl-12">
                        <div class="row customer">
                            <div class="col-12">
                                <div class="pedido-customer">
                                    <div class="box ">
                                        <div class="d-flex align-items-center justify-content-between box-header">
                                            @if ($cliente)
                                                <h4 class="box-title fw-600">Novo Pedido - {{ $cliente->razao_social }}
                                                </h4>
                                            @else
                                                <h4 class="box-title fw-600">Novo Pedido</h4>
                                            @endif

                                        </div>
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <button class="btn btn-success" id="new-pedido-customer"
                                                        style="width: 100%">Novo Pedido <i
                                                            class="fas fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    document.getElementById('new-pedido-customer').addEventListener('click', function() {
                                        document.querySelector('.new-pedido-customer').classList.remove('hidden');
                                        document.querySelector('.new-pedido-customer').classList.add('show');
                                    });
                                </script>

                                <div class="new-pedido-customer hidden" wire:ignore.self>
                                    <div class="box">
                                        <div class="d-flex align-items-center justify-content-between box-header">
                                            <h4 class="box-title fw-600">Novo Pedido</h4>
                                        </div>
                                        <div class="box-body">
                                            <div class="d-flex justify-content-between">
                                                <div class="form-group d-flex align-items-center mb-15">
                                                    <label>Referência:</label>
                                                    <input type="text" wire:model="referencia_inicial"
                                                        class="form-control w-75 ms-10" placeholder="1">
                                                    <input type="text" wire:model="referencia_final"
                                                        class="form-control w-75 mx-10" placeholder="100">
                                                    <button class="btn btn-primary-light btn-sm"
                                                        wire:click="atualizarProdutos"><i
                                                            class="fas fa-search"></i></button>
                                                </div>

                                                <div class="form-group d-flex align-items-center mb-15">
                                                    <label>Modelo:</label>
                                                    <input type="text" wire:model="modelo"
                                                        class="form-control w-75 mx-10" placeholder="Modelo">
                                                    <button class="btn btn-primary-light btn-sm"
                                                        wire:click="atualizarProdutos"><i
                                                            class="fas fa-search"></i></button>
                                                </div>
                                                <div class="form-group d-flex align-items-center mb-15">
                                                    <label>Fornecedor:</label>
                                                    <input type="text" wire:model="fornecedor"
                                                        class="form-control w-75 mx-10" placeholder="Fonecedor">
                                                    <button class="btn btn-primary-light btn-sm"
                                                        wire:click="atualizarProdutos"><i
                                                            class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table id="example1" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Referência</th>
                                                            <th>Quantidade</th>
                                                            <th>Modelo</th>
                                                            <th>Fornecedor</th>
                                                            <th>Movimentação</th>
                                                            <th>Status</th>
                                                            <th>Valor Unitário</th>
                                                            <th>Valor Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($produtos['data'] as $item)
                                                            <tr>
                                                                <td>
                                                                    <input type="checkbox"
                                                                        id="basic_checkbox_{{ $item['id'] }}"
                                                                        class="filled-in" value="{{ $item['id'] }}"
                                                                        wire:click="toggleProduto($event.target.value)"
                                                                        @if (in_array($item['id'], $produtosMarcados)) checked @endif>
                                                                    <label
                                                                        for="basic_checkbox_{{ $item['id'] }}"></label>
                                                                </td>

                                                                <td>{{ $item['referencia'] }}</td>
                                                                <td class="w-50">
                                                                    <div class="form-group">
                                                                        <input type="number" min="0"
                                                                            class="form-control"
                                                                            wire:model="quantidades.{{ $item['id'] }}"
                                                                            wire:change="calcula($event.target.value, {{ $item['preco_unitario'] }}, {{ $item['id'] }})"
                                                                            placeholder="0">
                                                                    </div>
                                                                </td>
                                                                <td>{{ $item['modelo'] }}</td>
                                                                <td>
                                                                    {{ $item['fornecedor']['razao_social'] ?? '' }}
                                                                </td>
                                                                @if ($item['quantidade'] < $item['estoque_seguranca'])
                                                                    <td style="color:rgb(255, 0, 0);"><i
                                                                            class="fas fa-warning"
                                                                            style="margin-right: 10px;"></i><b>{{ $item['quantidade'] }}</b>
                                                                    </td>
                                                                    <td>
                                                                        <div style="color:rgb(255, 0, 0); font-size: 25px;"
                                                                            class="icon-alert-animation">
                                                                            <i class="fas fa-warning"
                                                                                style="margin-right: 10px;"></i>
                                                                        </div>
                                                                    </td>
                                                                @else
                                                                    <td style="color:green;">
                                                                        <b>{{ $item['quantidade'] }}</b>
                                                                    </td>
                                                                    <td>
                                                                        <div
                                                                            style="color:rgb(5, 150, 7); font-size: 25px;">
                                                                            <i class="fas fa-check"
                                                                                style="margin-right: 10px;"></i>
                                                                        </div>
                                                                    </td>
                                                                @endif
                                                                <td><b>R$
                                                                        {{ number_format($item['preco_unitario'], 4, ',', '.') }}</b>
                                                                </td>
                                                                <td><b>R$
                                                                        {{ isset($valorUnitarios[$item['id']]) ? number_format($valorUnitarios[$item['id']], 2, ',', '.') : '0,00' }}</b>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <div class="d-flex justify-content-center mt-2">
                                                    {{-- Paginação --}}
                                                    @if ($produtos['last_page'] > 1)
                                                        <nav>
                                                            <ul class="pagination">
                                                                @if ($produtos['prev_page_url'])
                                                                    <li class="page-item">
                                                                        <a class="page-link"
                                                                            wire:click="atualizarPagina({{ $produtos['current_page'] - 1 }})"
                                                                            href="javascript:void(0)">Anterior</a>
                                                                    </li>
                                                                @endif
                                                                @for ($i = 1; $i <= $produtos['last_page']; $i++)
                                                                    <li
                                                                        class="page-item {{ $i == $produtos['current_page'] ? 'active' : '' }}">
                                                                        <a class="page-link"
                                                                            wire:click="atualizarPagina({{ $i }})"
                                                                            href="javascript:void(0)">{{ $i }}</a>
                                                                    </li>
                                                                @endfor
                                                                @if ($produtos['next_page_url'])
                                                                    <li class="page-item">
                                                                        <a class="page-link"
                                                                            wire:click="atualizarPagina({{ $produtos['current_page'] + 1 }})"
                                                                            href="javascript:void(0)">Próxima</a>
                                                                    </li>
                                                                @endif
                                                            </ul>
                                                        </nav>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="d-flex row justify-content-between">
                                                <div class="col-lg-2">
                                                    <button class="btn btn-sm btn-danger-light" id="limparCesta"
                                                        wire:click="limparCesta">Limpar cesta</button>
                                                    <script>
                                                        document.getElementById('limparCesta').addEventListener('click', function() {
                                                            const checkboxes = document.querySelectorAll('input[type="checkbox"].filled-in');
                                                            checkboxes.forEach(checkbox => {
                                                                checkbox.checked = false;
                                                            });
                                                            console.log(checkboxes)
                                                        });
                                                    </script>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label>Desconto (%)</label>
                                                        <div class="col-md-12 d-flex">
                                                            <input type="number" wire:model="desconto"
                                                                class="form-control" placeholder="%"
                                                                style="width: 85px;">

                                                            <button class="btn btn-primary-light btn-sm"
                                                                style="margin-left: 10px;width: 240px;"
                                                                wire:click="aplicaDesconto">Aplicar Desconto</button>
                                                        </div>
                                                    </div>
                                                    <h4 class="">Total: <b>R$
                                                            {{ number_format($valorTotal, 2, ',', '.') }}</b></h4>

                                                    <h4 class="text-danger mt-10">Total com desconto: <b>R$
                                                            @if ($valorTotalComDesconto == 0.0)
                                                                {{ number_format($valorTotal, 2, ',', '.') }}
                                                            @else
                                                                {{ number_format($valorTotalComDesconto, 2, ',', '.') }}
                                                            @endif
                                                        </b>
                                                    </h4>



                                                </div>
                                            </div>
                                            <div class="row mt-30">
                                                <div class="col-12">
                                                    <button wire:click="gerarPedido" id="pedido-modal"
                                                        class="btn btn-success" style="width: 100%"
                                                        wire:loading.attr="disabled">
                                                        <span wire:loading.remove wire:target="gerarPedido">Gerar
                                                            Pedido</span>
                                                        <span wire:loading wire:target="gerarPedido">
                                                            <i class="fas fa-spinner fa-spin"></i> Carregando...
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- /.content -->
    </div>



    <!-- /.modal cliente -->
    @if ($showModalCliente)
    <div class="modal fade cliente-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="clienteModal" aria-hidden="true"
    style="display: none;" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Selecione um cliente </h4>
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button> --}}
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <!-- Campos de pesquisa -->
                            <div class="row form-group align-items-end">
                                <div class="col-lg-6">
                                    <label class="form-label">Nome</label>
                                    <input type="text" wire:model="nomeCliente" class="form-control"
                                        placeholder="Nome do Cliente" maxlength="18">
                                </div>
                                <div class="col-lg-5">
                                    <label class="form-label">Documento</label>
                                    <input type="text" wire:model="numero_documento" class="form-control"
                                        placeholder="CPF/CNPJ" id="numero_documento_cnpj" maxlength="18">
                                </div>
                                <div class="col-lg-1">
                                    <button class="btn btn-primary-light" wire:click="buscarClientes"
                                        wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="buscarClientes">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        <span wire:loading wire:target="buscarClientes">
                                            <i class="fas fa-spinner fa-spin"></i>
                                        </span>
                                    </button>
                                </div>
                            </div>
                            <!-- Resultados da pesquisa -->
                            <div class="mt-3">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Documento</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($clientes as $cliente)
                                            <tr>
                                                <td>{{ $cliente->nome }}</td>
                                                <td>{{ $cliente->numero_documento }}</td>
                                                <td>
                                                    <button class="btn btn-success-light" wire:click="selecionarCliente({{ $cliente->id }})">
                                                        Selecionar
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3">Nenhum cliente encontrado.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-between">
                        <button type="button" wire:click="novoCliente" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Novo Cliente
                        </button>
                        <button type="button" data-bs-dismiss="modal"
                            aria-label="Close" class="btn btn-success me-1">
                            Próximo
                        </button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('numero_documento_cnpj');

            input.addEventListener('input', function(e) {
                let value = input.value.replace(/\D/g, ''); // Remove tudo que não é dígito

                // Limita o número máximo de caracteres (11 para CPF e 14 para CNPJ)
                if (value.length > 14) {
                    value = value.slice(0, 14);
                }

                if (value.length <= 11) {
                    // Máscara para CPF (11 dígitos)
                    input.value = value
                        .replace(/(\d{3})(\d)/, '$1.$2') // Primeiro bloco
                        .replace(/(\d{3})(\d)/, '$1.$2') // Segundo bloco
                        .replace(/(\d{3})(\d{1,2})$/, '$1-$2'); // Bloco final
                } else {
                    // Máscara para CNPJ (14 dígitos)
                    input.value = value
                        .replace(/^(\d{2})(\d)/, '$1.$2') // Primeiro bloco
                        .replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3') // Segundo bloco
                        .replace(/\.(\d{3})(\d)/, '.$1/$2') // Bloco da filial
                        .replace(/(\d{4})(\d{2})$/, '$1-$2'); // Dígitos verificadores
                }
            });
        });
    </script>

    <!-- /.modal pedido -->
    @if ($showModal)
        <div class="modal fade pedido-modal show" wire:ignore.self tabindex="-1" role="dialog"
            aria-labelledby="pedidoModal" aria-hidden="false" style="display: block;">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="resumo-pedido">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Resumo do Pedido</h4>
                            <button type="button" class="btn-close" wire:click="$set('showModal', false)"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row justify-content-center">
                                <div class="col-12 header-pedido">
                                    <h4>Data:
                                        {{ date('d/m/Y') }}
                                    </h4>
                                    <img class="img-fluid" src="imgs/logo.jpg" style="width: 100px">
                                </div>
                                <div class="col-md-12">
                                    <div class="row mb-20">
                                        <div class="col-6">
                                            <h4>Cliente: {{ $this->cliente->nome }}</h4>
                                            <h5>CPF/CNPJ: {{ $this->cliente->numero_documento }}</h5>
                                            <h5>Telefone: {{ $this->cliente->telefone }}</h5>
                                            <h5>Email: {{ $this->cliente->email }}</h5>
                                        </div>
                                        <div class="col-6">
                                            <h5>Endereço: {{ $this->cliente->endereco }}, {{ $this->cliente->numero }}
                                                -
                                                {{ $this->cliente->cidade }}/{{ $this->cliente->uf }}</h5>
                                            <h5>Bairro: {{ $this->cliente->bairro }}</h5>
                                            <h5>CEP:{{ $this->cliente->cep }}</h5>
                                            <h5>Vendedor:</h5>
                                        </div>
                                    </div>
                                    <div class="table-responsive mb-20" style="max-height: 400px; padding: 10px 30px">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Referência</th>
                                                    <th>Modelo</th>
                                                    <th>Quantidade</th>
                                                    <th>Valor Unitário</th>
                                                    <th>Valor Total</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!empty($produtosEscolhidos))
                                                    @foreach ($produtosEscolhidos as $key => $item)
                                                        <tr>
                                                            <td>{{ $item['referencia'] }}</td>
                                                            <td>{{ $item['modelo'] }}</td>
                                                            <td><b>{{ $item['quantidade'] }}</b></td>
                                                            <td><b>R$ {{ number_format($item['preco_unitario'], 4, ',', '.') }}</b></td>
                                                            <td><b>R$ {{ number_format($item['valor_total'], 2, ',', '.') }}</b></td>
                                                            <td>
                                                                <a data-bs-toggle="modal" 
                                                                   wire:click="excluiProduto({{ $item['id'] }})" 
                                                                   href="#">
                                                                   <i class="fas fa-trash"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row justify-content-between">
                                        <div class="col-lg-6 col-sm-12 col-md-6 d-flex flex-column">
                                            <div class="d-flex">
                                                <div class="form-group">
                                                    <input name="group5" wire:model.live="metodoEntrega" type="radio"
                                                        id="balcao" class="with-gap radio-col-success" value="balcao">
                                                    <label for="balcao">Balcão</label>
                                                </div>
                                                <div class="ms-10 form-group">
                                                    <input name="group5" wire:model.live="metodoEntrega" type="radio"
                                                        id="entrega" class="with-gap radio-col-success"
                                                        value="entrega">
                                                    <label for="entrega">Entrega</label>
                                                    <div id="endereco"
                                                        class="{{ $metodoEntrega == 'entrega' ? '' : 'hidden' }}">
                                                        <div class="d-flex my-10">
                                                            <input type="text" wire:model="endereco"
                                                                class="form-control" placeholder="Endereço">
                                                            <input type="text" wire:model="numero"
                                                                class="form-control mx-10" placeholder="Número">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mt-10">
                                                <label>Observações</label>
                                                <div class="d-flex">
                                                    <input type="text" class="form-control"
                                                        wire:model="observacao"
                                                        placeholder="Digite a observação" /><br>
                                                    <button class="btn btn-sm btn-success mx-10">
                                                        <i class="fas fa-check"></i> Confirmar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12 col-md-6">
                                            <div class="d-flex flex-column align-items-end my-10">
                                                <h4 class="">Total: <b>R$
                                                        {{ number_format($valorTotal, 2, ',', '.') }}</b></h4>

                                                <h4 class="text-danger mt-10">Total com desconto: <b>R$
                                                        @if ($valorTotalComDesconto == 0.0)
                                                            {{ number_format($valorTotal, 2, ',', '.') }}
                                                        @else
                                                            {{ number_format($valorTotalComDesconto, 2, ',', '.') }}
                                                        @endif
                                                    </b>
                                                </h4>
                                                <h7>Desconto de
                                                    {{ number_format($this->descontoAplicado, 2, ',', '.') }}%</h7>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-between">
                            <button type="button" wire:click="fecharModalResumoPedido" id="editar-pedido-btn"
                                class="btn btn-primary">
                                <i class="fas fa-edit"></i> Editar Pedido
                            </button>
                            <button type="button" wire:click="finalizarPedido" class="btn btn-success"
                                wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="finalizarPedido">Gerar Pedido</span>
                                <span wire:loading wire:target="finalizarPedido">
                                    <i class="fas fa-spinner fa-spin"></i> Carregando...
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('closeModal', (event) => {
            $('.cliente-modal').modal('hide');
        });
    });
    document.addEventListener('livewire:load', () => {
        Livewire.hook('message.processed', (component, message) => {
            if (!component.get('modalAberta')) {
                $('.cliente-modal').modal('hide'); // Fecha a modal
            }
        });
    });
    document.addEventListener('DOMContentLoaded', () => {
        // Escuta os cliques em todos os botões com a classe "btn-success"
        document.querySelectorAll('.btn-success-light').forEach(button => {
            button.addEventListener('click', function () {
                // Alterar o texto do botão para "Selecionado"
                this.innerHTML = 'Selecionado';
                this.disabled = true; // Opcional: desativa o botão após o clique
            });
        });
    });
</script>
