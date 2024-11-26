<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th></th>
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
                    <input type="checkbox" id="basic_checkbox_{{ $produto->id }}" class="filled-in">
                    <label for="basic_checkbox_{{ $produto->id }}"></label>
                </td>
                <td>{{ $produto->referencia }}</td>
                <td>{{ $produto->modelo }}</td>
                <td>{{ $produto->fornecedor->razao_social }}</td>
                <td>{{ $produto->quantidade }}</td>
                <td><b>R$ {{ number_format($produto->valor_unitario, 2, ',', '.') }}</b></td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="d-flex justify-content-center">
    {{ $produtos->links() }}
</div>
