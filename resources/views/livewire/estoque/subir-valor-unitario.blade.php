@section('title', 'Valor Unitário - Combrim')

<div>
    <div class="box-body">
        <div class="row">
            <h5>Selecione o fornecedor</h5>
            <hr class="my-15">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="form-label">Fornecedor</label>
                    <select class="form-select" wire:model.live="id_fornecedor">
                        <option value="">Selecione um fornecedor</option>
                        @foreach ($fornecedores as $fornecedor)
                            <option value="{{ $fornecedor['id'] }}">
                                {{ $fornecedor->razao_social }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th>ID</th>
                                <th>Referência</th>
                                <th>Modelo</th>
                                <th>Fornecedor</th>
                                <th>Movimentação</th>
                                <th>Valor Unitário</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($produtos as $produto)
                                <tr>
                                    <td>
                                        <input type="hidden" value="{{ $produto->id }}"
                                            name="produto[{{ $produto->id }}][id]">
                                        <input type="checkbox" name="produto[{{ $produto->id }}][check]"
                                            id="basic_checkbox_{{ $produto->id }}" class="filled-in">
                                        <label for="basic_checkbox_{{ $produto->id }}"></label>
                                    </td>
                                    <td>#{{ $produto->id }}</td>
                                    <td>{{ $produto->referencia }}</td>
                                    <td>{{ $produto->modelo }}</td>
                                    <td>{{ $fornecedor->razao_social }}</td>
                                    <td>{{ $produto->quantidade }}</td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" id="preco_unitario_massivo_{{ $produto->id }}"
                                                name="produto[{{ $produto->id }}][preco_unitario]"
                                                class="form-control"
                                                value="R$ {{ number_format($produto->preco_unitario, 4, ',', '.') }}"
                                                placeholder="R$0,00">
                                        </div>
                                    </td>
                                </tr>

                                <script>
                                    document.getElementById("preco_unitario_massivo_{{ $produto->id }}").addEventListener('input', function(e) {
                                        let value = e.target.value.replace(/\D/g, '');

                                        if (value) {
                                            value = (parseInt(value, 10) / 100).toLocaleString('pt-BR', {
                                                style: 'currency',
                                                currency: 'BRL'
                                            });
                                            e.target.value = value;
                                        } else {
                                            e.target.value = '';
                                        }
                                    });
                                </script>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
