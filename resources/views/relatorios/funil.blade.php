@section('title', 'Relatórios - Combrim')

@extends('components.main')
@section('content')
<div class="container">
    <h1 class="mt-3">Relatório de Vendas Mensais - Ano {{ $anoSelecionado }}</h1>

    {{-- Formulário para Seleção de Ano --}}
    <div class="mb-3">
        <form action="{{ route('relatorio.funil.get') }}" method="GET" class="form-inline"> {{-- Certifique-se que o nome da rota está correto --}}
            <label for="ano" class="mr-2">Selecionar Ano:</label>
            <select name="ano" id="ano" class="form-control mr-2" onchange="this.form.submit()">
                @foreach($anosDisponiveis as $ano)
                    <option value="{{ $ano }}" {{ $ano == $anoSelecionado ? 'selected' : '' }}>
                        {{ $ano }}
                    </option>
                @endforeach
            </select>
            {{-- O botão é opcional se usar onchange no select --}}
            {{-- <button type="submit" class="btn btn-primary">Filtrar</button> --}}
        </form>
    </div>

    {{-- Container para o Gráfico --}}
    <div style="max-width: 800px; margin: auto;">
        <canvas id="graficoVendasMensais"></canvas>
    </div>

    <hr>

    {{-- Seção Opcional: Vendas por Região (se incluído nos dados) --}}
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
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('graficoVendasMensais').getContext('2d');

        const labels = @json($labelsMeses);
        const salesData = @json($dadosVendas);
        const anoSelecionado = @json($anoSelecionado);

        const myChart = new Chart(ctx, {
            type: 'line', // Tipo de gráfico: linha
            data: {
                labels: labels, // ['Jan', 'Fev', ...]
                datasets: [{
                    label: `Vendas em ${anoSelecionado}`, // Título da legenda
                    data: salesData, // [valorJan, valorFev, ...]
                    borderColor: 'rgb(75, 192, 192)', // Cor da linha
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Cor do preenchimento abaixo da linha (opcional)
                    tension: 0.1, // Curvatura da linha (0 = reto)
                    fill: true, // Preencher abaixo da linha
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true, // Pode ser false se quiser controlar o aspect ratio via CSS
                plugins: {
                    title: {
                        display: true,
                        text: `Total de Vendas Mensais - ${anoSelecionado}` // Título principal do gráfico
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    // Formata o valor como moeda Brasileira
                                    label += new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true, // Começar o eixo Y no zero
                        ticks: {
                            // Formatar os ticks do eixo Y como moeda
                            callback: function(value, index, values) {
                                return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL', minimumFractionDigits: 0 }).format(value);
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection