<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido #{{ $pedido['id'] }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        #cliente-infos {
            border: 1px solid #777;
            padding: 10px;
            margin-top: 15px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px; /* Reduzi o gap para melhor acomodação em PDF */
        }

        #cliente-infos > table {
            border: 0px
        }

        #cliente-infos > table > thead{
            border: 0px
        }

        #cliente-infos > table > tbody {
            border: 0px
        }

        #cliente-infos > table > th, td {
            border: 0px
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
            font-size: 14px; /* Adicionado para controle do tamanho da fonte */
        }
        h2 {
            margin-top: 20px;
        }

        h3 {
            margin-bottom: 5px;
        }
        p {
            margin: 3px 0; /* Reduzi o espaçamento dos parágrafos */
        }
    </style>
</head>

<body>

    <div style="display: flex; justify-content: center; margin-bottom: 20px;">
        <img src="imgs/logo.jpg" alt="Logo" style="width: 100px; max-width: 100%;">
    </div>
    <div id="cliente-infos">
        <div >
            <h2 style="margin: 0;">Pedido #{{ $pedido['id'] }}</h2>
        </div>
        <table>
            <thead>
                <tr style="margin-bottom: 0px;">
                    <th style="border: 0px solid #000; padding: 0px 5px">Cliente:</th>
                    <th style="border: 0px solid #000; padding: 0px 5px">Documento:</th>
                </tr>
            </thead>
            <tbody>
                <tr style="margin-bottom: 0px;">
                    <td style="border: 0px solid #000; padding: 0px 5px">{{ $pedido['razao_social'] }}</td>
                    <td style="border: 0px solid #000; padding: 0px 5px">{{ $cliente['numero_documento'] }}</td>
                </tr>
            </tbody>
        </table>
        <table>
            <thead>
                <tr style="margin-bottom: 0px;">
                    <th style="border: 0px solid #000; padding: 0px 5px">Telefone:</th>
                    <th style="border: 0px solid #000; padding: 0px 5px">Email:</th>
                    <th style="border: 0px solid #000; padding: 0px 5px">Data do Pedido:</th>
                </tr>
            </thead>
            <tbody>
                <tr style="margin-bottom: 0px;">
                    <td style="border: 0px solid #000; padding: 0px 5px">{{ $cliente['telefone'] }}</td>
                    <td style="border: 0px solid #000; padding: 0px 5px">{{ $cliente['email'] }}</td>
                    <td style="border: 0px solid #000; padding: 0px 5px">{{ \Carbon\Carbon::parse($pedido['data'])->format('d/m/Y') }}</td>
                </tr>
            </tbody>
        </table>
        <table>
            <thead>
                <tr style="margin-bottom: 0px;">
                    <th style="border: 0px solid #000; padding: 0px 5px">Endereço:</th>
                </tr>
            </thead>
            <tbody>
                <tr style="margin-bottom: 0px;">
                    <td style="border: 0px solid #000; padding: 0px 5px">{{ $cliente['endereco'] }}, {{ $cliente['numero'] }} -
                    {{ $cliente['cidade'] }}/{{ $cliente['uf'] }} - {{ $cliente['cep'] }}</td>
                </tr>
            </tbody>
        </table>
        <table>
            <thead>
                <tr style="margin-bottom: 0px;">
                    <th style="border: 0px solid #000; padding: 0px 5px">Vendedor:</th>
                    <th style="border: 0px solid #000; padding: 0px 5px">{{ $pedido->balcao == 1 ? 'Retirada' : 'Entrega em' }}:</th>
                    <th style="border: 0px solid #000; padding: 0px 5px">Observações:</th>
                </tr>
            </thead>
            <tbody>
                <tr style="margin-bottom: 0px;">
                    <td style="border: 0px solid #000; padding: 0px 5px">{{ $pedido->vendedor ? $pedido->vendedor->usuario : 'Admin' }}</td>
                    <td style="border: 0px solid #000; padding: 0px 5px">{{ $pedido->balcao == 1 ? 'Balcão' : $pedido['endereco'] . ' ' . $pedido['numero'] }}</td>
                    <td style="border: 0px solid #000; padding: 0px 5px">{{ $pedido->observacoes }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <h2>Itens do Pedido</h2>
    <table>
        <thead>
            <tr>
                <th>Referência</th>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Fornecedor</th>
                <th>Valor Unitário</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pedidoItems as $item)
                <tr>
                    <td>{{ $item['referencia'] }}</td>
                    <td>{{ $item['modelo'] }}</td>
                    <td>{{ $item['quantidade'] }}</td>
                    <td>{{ $item['fornecedor'] }}</td>
                    <td>{{ number_format($item['valor_unitario'], 4, ',', '.') }}</td>
                    <td>{{ number_format($item['quantidade'] * $item['valor_unitario'], 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    

    <table style="margin-top: 20px;">
        <thead>
            <tr>
                <th style="border: 0px solid #000; padding: 0px 5px">Produtos selecionados:</th>
                <th style="align: right;border: 0px solid #000; padding: 0px 5px">Valor</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="border: 0px solid #000; padding: 0px 5px">
                    <p style="margin-top: 10px;"><strong>{{ $pedido['numero_produtos'] }}</strong></p>
                </td>
                <td style="align: right;border: 0px solid #000; padding: 0px 5px">
                    @if ($pedido->desconto > 0)
                        <h4 style="color: red;">À vista:
                            R${{ number_format($valorComDesconto, 2, ',', '.') }}</h4>
                        <h5 style="margin:0;">À Prazo: R${{ number_format($pedido['valor'], 2, ',', '.') }}</h5>
                        <p style="margin:0;">Prazo para pagamento: <strong>À Vista</strong></p>
                    @else
                        <h4 style="margin:0;">À Prazo: R${{ number_format($pedido['valor'], 2, ',', '.') }}</h4>
                        <p style="margin:0;">Prazo para pagamento: <strong>30 Dias</strong></p>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
    @if ($pedido->desconto > 0)
        <p style="margin:0;">Desconto: {{ $pedido['desconto'] }}%</p>
    @endif

</body>

</html>