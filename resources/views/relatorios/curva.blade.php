@section('title', 'Relatórios - Combrim')

@extends('components.main')
@section('content')
    <style>
        /* Estilos para o layout e gráficos */
        h1 { text-align: center; margin-bottom: 20px; color: #333; }
        #logo { margin-top: 20px; width: 150px; display: block; margin-left: auto; margin-right: auto; }
        label { font-size: 14px; margin-top: 20px; margin-bottom: 10px; color: #555; }
        select { padding: 8px 12px; font-size: 14px; border: 1px solid #ddd; border-radius: 5px; cursor: pointer; outline: none; }
        .chart-container { display: flex; justify-content: space-between; gap: 20px; flex-wrap: wrap; width: 100%; max-width: 1200px; margin-top: 30px; }
        #chart_div { flex: 1 1 100%; height: 400px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); background-color: #ffffff; }
        .chart-container > div { min-width: 400px; height: 400px; }
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        @media (max-width: 768px) { .chart-container { flex-direction: column; gap: 20px; } #chart_div { width: 100%; } }
    </style>
    
<div class="mt-50">
    <h1>Relatório Gráfico - Vendas Mensais de 2025</h1>

    <table>
        <thead>
            <tr>
                <th>Mês</th>
                <th>Vendas</th>
            </tr>
        </thead>
        <tbody>
            @php
                $data = json_decode($jsonData, true);
            @endphp
            @foreach($data as $index => $row)
                @if($index > 0)  <!-- Ignora a linha de cabeçalho -->
                    <tr>
                        <td>{{ $row[0] }}</td>
                        <td>{{ $row[1] }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <canvas class="mt-50" id="salesChart"></canvas>
</div>
<script>
    // Transform PHP data to JavaScript
    const data = @json($data);
    
    // Extract months and sales data (skip header row)
    const months = data.slice(1).map(row => row[0]);
    const sales = data.slice(1).map(row => row[1]);

    // Create the chart
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Vendas por Mês',
                data: sales,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Vendas'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Mês'
                    }
                }
            }
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection