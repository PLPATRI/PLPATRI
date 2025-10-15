@extends('components.main')

@section('title', 'Relatórios - Vendas por Vendedor')

@section('content')
<div class="container">
    <h1 class="mt-3">Relatório de Vendas por Vendedor - Ano {{ $anoSelecionado }}</h1>

    {{-- Formulário de Seleção para Ordenar --}}
    <div class="mb-3">
        <form method="GET" action="{{ route('relatorio.vendedores.get') }}" class="form-inline">
            <label for="order" class="mr-2">Ordenar por Total de Vendas:</label>
            <select name="order" id="order" class="form-control mr-2" onchange="this.form.submit()">
                <option value="asc" {{ $order == 'asc' ? 'selected' : '' }}>Crescente</option>
                <option value="desc" {{ $order == 'desc' ? 'selected' : '' }}>Decrescente</option>
            </select>
        </form>
    </div>

    {{-- Tabela de Vendedores e Vendas --}}
    <h2>Vendas por Vendedor</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Vendedor</th>
                <th>Total de Vendas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vendedores as $vendedor)
            <tr>
                <td>{{ $vendedor->nome_vendedor ?? 'Desconhecido' }}</td> <!-- Nome do vendedor -->
                <td>R$ {{ number_format($vendedor->total_vendas, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Gráfico de Vendas por Vendedor --}}
    <div class="chart-container" style="max-width: 500px; margin: auto;">  
        <canvas id="salesChart"></canvas>
    </div>

</div>

{{-- Incluir Chart.js (via CDN ou localmente) --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
   document.addEventListener('DOMContentLoaded', function () {
    // Substituindo os valores nulos por 'Desconhecido' nas labels
    var labels = @json($labels).map(label => label === null ? 'Desconhecido' : label);
    var data = @json($data);

    console.log('Labels:', labels); // Verificando se há valores nulos sendo substituídos
    console.log('Data:', data);

    var colors = ['#ff6384', '#36a2eb', '#ffcd56', '#4bc0c0', '#f86f2e', '#FF5733', '#33FF57', '#5733FF', '#9b59b6', '#e74c3c'];

    // Garantir que temos cores suficientes
    while (colors.length < labels.length) {
        colors.push('#' + Math.floor(Math.random() * 16777215).toString(16)); // Gera uma cor aleatória
    }

    if (labels.length > 0 && data.length > 0) {
        var ctx = document.getElementById('salesChart').getContext('2d');
        var salesChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Vendas por Vendedor',
                    data: data,
                    backgroundColor: colors,  // Usar o array de cores
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,  // Gráfico será responsivo
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return 'R$ ' + tooltipItem.raw.toFixed(2).replace('.', ',');
                            }
                        }
                    }
                }
            }
        });
    } else {
        console.log("Nenhum dado disponível para o gráfico.");
    }
});
</script>

@endsection
