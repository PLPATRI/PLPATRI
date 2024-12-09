<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- @php
        dd($pedido);
        $pedido = json_decode($pedido, true);
    @endphp --}}
    <title>Pedido #{{ $pedido['id'] }}</title>
</head>

<body>

    <img class="img-fluid" src="imgs/logo.jpg" style="width: 100px">
    <h1>Pedido #{{ $pedido['id'] }}</h1>
    <p><strong>Cliente:</strong> {{ $pedido['razao_social'] }}</p>
    <p><strong>Status:</strong> {{ $pedido['status'] }}</p>
    <p><strong>Data do Pedido:</strong> {{ \Carbon\Carbon::parse($pedido['data'])->format('d/m/Y') }}</p>
    <p><strong>Endereço:</strong>{{ $cliente['endereco'] }}, {{ $cliente['numero'] }} -
        {{ $cliente['cidade'] }}/{{ $cliente['uf'] }} -
        {{ $cliente['cep'] }}</p>
    @if ($pedido->balcao == 1)
    <p><strong>Retirada</strong> Balcão</p>
    @else
    <p><strong>Entrega em:</strong> {{ $pedido['endereco'] }} {{ $pedido['numero'] }}</p>
    @endif    
   

    <h2>Itens do Pedido</h2>
    <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Valor Unitario</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pedidoItems as $item)
                <tr>
                    <td>{{ $item['modelo'] }}</td>
                    <td>{{ $item['quantidade'] }}</td>
                    <td>{{ number_format($item['valor_unitario'], 4, ',', '.') }}</td>
                    <td>{{ number_format($item['quantidade'] * $item['valor_unitario'], 4, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <h3>À Prazo: R$ {{ number_format($pedido['valor'], 2, ',', '.') }}</h3>
    <h3 style="color: red; margin-bottom: 5px">À Vista: R$ {{ number_format($valorComDesconto, 2, ',', '.') }}</h3>
    <p>
        Desconto:{{$pedido['desconto']}}%
    </p>

</body>

</html>
