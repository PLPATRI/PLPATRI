@section('title', 'Relatórios - Combrim')

@extends('components.main')
@section('content')
<div class="container">
    <h1 class="mt-3">Relatório de Vendas Mensais - Ano {{ $anoSelecionado }}</h1>

    {{-- Formulário para Seleção de Ano --}}
    <div class="mb-3">
        <form action="{{ route('relatorio.funil.get') }}" method="GET" class="form-inline">
            <label for="ano" class="mr-2">Selecionar Ano:</label>
            <select name="ano" id="ano" class="form-control mr-2" onchange="this.form.submit()">
                @foreach($anosDisponiveis as $ano)
                    <option value="{{ $ano }}" {{ $ano == $anoSelecionado ? 'selected' : '' }}>
                        {{ $ano }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    {{-- Formulário para Seleção de Tipo de Gráfico --}}
    <div class="mb-3">
        <label for="tipoGrafico" class="mr-2">Tipo de Gráfico:</label>
        <select id="tipoGrafico" class="form-control" onchange="atualizarTipoGrafico(this.value)">
            <option value="line" selected>Linha</option>
            <option value="bar">Coluna</option>
        </select>
    </div>

    {{-- Container para o Gráfico --}}
    <div style="max-width: 800px; margin: auto;">
        <canvas id="graficoVendasMensais"></canvas>
    </div>

    <hr>

    {{-- Seção Opcional: Vendas por Região --}}
    @if(isset($vendasPorRegiao) && !empty($vendasPorRegiao))
        <h2>Vendas por Região (Total - Sem Filtro de Ano Específico por Padrão)</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Região</th>
                    <th>Total Vendas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vendasPorRegiao as $regiao => $total)
                <tr>
                    <td>{{ $regiao ?: 'Não especificada' }}</td>
                    <td>R$ {{ number_format($total, 2, ',', '.') }}</td>
                </tr>
                @endforeach
                <tr class="font-weight-bold">
                     <td>Total Brasil</td>
                     <td>R$ {{ number_format($totalVendasBrasil, 2, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    @endif
</div>

{{-- Incluir Chart.js (via CDN ou localmente) --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    let chartInstance;

    function criarGrafico(tipo) {
        const ctx = document.getElementById('graficoVendasMensais').getContext('2d');

        if (chartInstance) {
            chartInstance.destroy(); // Destrói o gráfico anterior
        }

        chartInstance = new Chart(ctx, {
            type: tipo,
            data: {
                labels: @json($labelsMeses),
                datasets: [{
                    label: `Vendas em {{ $anoSelecionado }}`,
                    data: @json($dadosVendas),
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgb(75, 192, 192)',
                    borderWidth: 1,
                    fill: tipo === 'line'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: `Total de Vendas Mensais - {{ $anoSelecionado }}`
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) label += ': ';
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('pt-BR', {
                                        style: 'currency',
                                        currency: 'BRL'
                                    }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat('pt-BR', {
                                    style: 'currency',
                                    currency: 'BRL',
                                    minimumFractionDigits: 0
                                }).format(value);
                            }
                        }
                    }
                }
            }
        });
    }

    function atualizarTipoGrafico(tipoSelecionado) {
        criarGrafico(tipoSelecionado);
    }

    document.addEventListener('DOMContentLoaded', function () {
        criarGrafico('line'); // Carrega o gráfico como linha por padrão
    });
</script>
@endsection
