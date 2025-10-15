@section('title', 'Relatórios - Curva ABC')

@extends('components.main')

@section('content')
<div class="container">
    <h1 class="mt-3" style="margin-bottom: 0;">Relatório de Curva ABC de Vendas - Ano {{ $anoSelecionadoABC }}</h1>

    <h2 style="margin-top: 0;">Vendas por Produto - Curva ABC</h2>

    {{-- Combo para selecionar o número de itens por página --}}
    <div class="form-group">
        <label for="itensPorPagina">Itens por Página</label>
        <select id="itensPorPagina" class="form-control" onchange="limitarPagina()">
            <option value="10" {{ request()->get('itensPorPagina') == 10 ? 'selected' : '' }}>10</option>
            <option value="20" {{ request()->get('itensPorPagina') == 20 ? 'selected' : '' }}>20</option>
            <option value="50" {{ request()->get('itensPorPagina') == 50 ? 'selected' : '' }}>50</option>
            <option value="100" {{ request()->get('itensPorPagina') == 100 ? 'selected' : '' }}>100</option>
			
        </select>
    </div>

    {{-- Botão para abrir o modal --}}
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#curvaABCModal">
        Como funciona a Curva ABC
    </button>

    {{-- Modal de Explicação --}}
    <div class="modal fade" id="curvaABCModal" tabindex="-1" role="dialog" aria-labelledby="curvaABCModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="curvaABCModalLabel">Como funciona a Curva ABC</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>A Curva ABC é uma técnica de categorização dos produtos de uma empresa com base no seu valor de vendas. A ideia é classificar os produtos em três grupos:</p>
                    <ul>
                        <li><strong>Classe A:</strong> Produtos com o maior valor de vendas. Representam aproximadamente 20% dos produtos, mas geram cerca de 80% da receita.</li>
                        <li><strong>Classe B:</strong> Produtos com valor de vendas médio. Representam cerca de 30% dos produtos e geram 15% da receita.</li>
                        <li><strong>Classe C:</strong> Produtos com o menor valor de vendas. Representam a maior parte dos produtos (50%) e geram apenas 5% da receita.</li>
                    </ul>
                    <p>Essa classificação permite que a empresa foque seus esforços nos produtos mais lucrativos e otimize sua gestão de inventário e vendas.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Container para o Gráfico da Curva ABC --}}
    <div style="max-width: 800px; margin: auto;">
        <canvas id="graficoCurvaABC"></canvas>
    </div>

    <hr>

    {{-- Tabela com a Curva ABC --}}
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Total Qtde de Vendas</th>
                <th>Cumulativo (%)</th>
                <th>Classe</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produtosABC->sortBy('classe')->take(request()->get('itensPorPagina', 10)) as $produto)
                <tr>
                    <td>{{ $produto['nome'] }}</td>
                    <td>{{ number_format($produto['total_vendas'], 0, ',', '.') }}</td> 
                    <td>{{ number_format($produto['cumulativo'], 2, ',', '.') }}%</td>
                    <td>{{ $produto['classe'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>

{{-- Incluir Bootstrap e Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Função para atualizar a URL com o novo limite de itens
    function limitarPagina() {
        const itensPorPagina = document.getElementById('itensPorPagina').value;
        const url = new URL(window.location.href);
        url.searchParams.set('itensPorPagina', itensPorPagina); // Atualiza o parâmetro da URL
        window.location.href = url.toString(); // Redireciona com o novo parâmetro
    }

    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('graficoCurvaABC').getContext('2d');

        const labels = @json($produtosABC->pluck('nome')); // Pluck 'nome' de cada produto
        const salesData = @json($produtosABC->pluck('total_vendas')); // Pluck 'total_vendas'
        const cumulativoData = @json($produtosABC->pluck('cumulativo')); // Pluck 'cumulativo'

        const myChart = new Chart(ctx, {
            type: 'line', // Usar gráfico de linha para as duas curvas
            data: {
                labels: labels, // ['Produto A', 'Produto B', ...]
                datasets: [
                    {
                        label: 'Total de Vendas',
                        data: salesData, // [5000, 3000, ...]
                        borderColor: 'rgb(75, 192, 192)', // Cor da linha de vendas
                        backgroundColor: 'rgba(75, 192, 192, 0.2)', // Cor do fundo da linha
                        borderWidth: 2,
                        fill: false, // Não preencher a área abaixo da linha de vendas
                        tension: 0.4, // Curvar a linha para suavizar os pontos
                    },
                    {
                        label: 'Cumulativo (%)',
                        data: cumulativoData, // [30, 50, ...]
                        borderColor: 'rgb(255, 99, 132)', // Cor da linha do cumulativo
                        backgroundColor: 'rgba(255, 99, 132, 0.2)', // Cor do fundo da linha
                        borderWidth: 2,
                        fill: false, // Não preencher a área abaixo da linha do cumulativo
                        tension: 0.4, // Curvar a linha para suavizar os pontos
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    title: {
                        display: true,
                        text: `Curva ABC de Vendas - Ano ${anoSelecionadoABC}`
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                    },
                    y: {
                        beginAtZero: true,
                        max: 100, // Ajustar o máximo para garantir que o acumulativo (%) esteja visível
                        ticks: {
                            callback: function(value, index, values) {
                                return value + '%'; // Exibir o valor como percentual no eixo Y
                            }
                        }
                    }
                }
            }
        });
    });
</script>

@endsection
