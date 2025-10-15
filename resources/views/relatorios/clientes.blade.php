@extends('components.main')

@section('title', 'Relatório de Compradores - Combrim')

@section('content')
<div class="container">
    <h1 class="mt-3">Relatório de Clientes que mais compraram</h1>

    {{-- Formulário para selecionar a ordenação --}}
    <div class="mb-3">
        <form action="{{ route('relatorio.clientes.get') }}" method="GET" class="form-inline">
            <label for="ordem" class="mr-2">Ordenar por:</label>
            <select name="ordem" id="ordem" class="form-control" onchange="this.form.submit()">
                <option value="desc" {{ $ordem === 'desc' ? 'selected' : '' }}>Mais Compraram</option>
                <option value="asc" {{ $ordem === 'asc' ? 'selected' : '' }}>Menos Compraram</option>
            </select>
        </form>
    </div>

    {{-- Tabela de Compradores --}}
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Razão Social</th>
                <th>CPF/CNPJ</th>
                <th>Telefone</th>
                <th>Total de Compras</th>
            </tr>
        </thead>
        <tbody>
            @foreach($compradores as $comprador)
                <tr>
                    <td>{{ $comprador->razao_social }}</td>
                    <td>{{ $comprador->cpf_cnpj }}</td>
                    <td>{{ $comprador->telefone }}</td>
                    <td>R$ {{ number_format($comprador->total_compras, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Paginação --}}
    <div class="d-flex justify-content-center">
        {{ $compradores->links() }}
    </div>

    {{-- Gráfico de Pizza --}}
    <div class="mt-5">
        <h3>Distribuição das Compras</h3>
        <canvas id="graficoCompradores" width="400" height="400"></canvas>
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- Script do Gráfico --}}
<script>
    const ctx = document.getElementById('graficoCompradores').getContext('2d');
    const graficoCompradores = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($compradores->pluck('razao_social')) !!},
            datasets: [{
                label: 'Total de Compras',
                data: {!! json_encode($compradores->pluck('total_compras')) !!},
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                    '#9966FF', '#FF9F40', '#C9CBCF', '#8BC34A',
                    '#FF5722', '#00BCD4', '#CDDC39', '#607D8B'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let value = context.raw;
                            return 'R$ ' + value.toLocaleString('pt-BR', {minimumFractionDigits: 2});
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
