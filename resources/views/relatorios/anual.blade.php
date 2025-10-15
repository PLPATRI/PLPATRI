@extends('components.main')

@section('title', 'Relatório Anual')

@section('content')
<div class="container">
    <h1 class="mt-3">Relatório de Vendas Anuais - 2025 vs 2026</h1>

    {{-- Formulário para Seleção de Ano --}}
    <div class="mb-3">
        <form action="{{ route('relatorio.anual.get') }}" method="GET" class="form-inline">
            <label for="ano" class="mr-2">Selecionar Ano:</label>
            <select name="ano" id="ano" class="form-control mr-2" onchange="this.form.submit()">
                @foreach($anosDisponiveis as $ano)
                    <option value="{{ $ano }}" {{ $ano == $anoSelecionadoanual ? 'selected' : '' }}>
                        {{ $ano }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    {{-- Formulário para Tipo de Visualização --}}
    <div class="mb-3">
        <label for="tipoVisualizacao" class="mr-2">Tipo de Visualização:</label>
        <select id="tipoVisualizacao" class="form-control" onchange="atualizarVisualizacao(this.value)">
            <option value="grafico" selected>Gráfico</option>
            <option value="pizza">Gráfico Pizza</option>
            <option value="relatorio">Relatório</option>
        </select>
    </div>

    {{-- Formulário para Seleção de Tipo de Gráfico (só aparece quando gráfico está selecionado) --}}
    <div class="mb-3" id="opcaoTipoGrafico">
        <label for="tipoGrafico" class="mr-2">Tipo de Gráfico:</label>
        <select id="tipoGrafico" class="form-control" onchange="atualizarTipoGrafico(this.value)">
            <option value="line" selected>Linha</option>
            <option value="bar">Coluna</option>
        </select>
    </div>

    {{-- Gráfico de Comparação --}}
    <div style="max-width: 800px; margin: auto;" id="containerGrafico">
        <canvas id="graficoVendasAnuais"></canvas>
    </div>

    {{-- Tabela do Relatório (inicialmente oculta) --}}
    <div id="containerRelatorio" style="max-width: 800px; margin: auto; display: none;">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Mês</th>
                    <th class="text-right">Vendas 2025</th>
                    <th class="text-right">Vendas 2026</th>
                    <th class="text-right">Variação %</th>
                </tr>
            </thead>
            <tbody id="relatorioBody">
                <!-- Dados preenchidos via JavaScript -->
            </tbody>
        </table>
    </div>
</div>

{{-- Incluir Chart.js (via CDN) --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    let chartInstance;
    const mesesNomes = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
    
    // Obter dados de vendas do backend
    const vendas2025Data = @json($vendas2025);
    const vendas2026Data = @json($vendas2026);

    // Função para atualizar visualização (gráfico, pizza ou relatório)
    function atualizarVisualizacao(tipo) {
        // Esconder/mostrar elementos relevantes
        const containerGrafico = document.getElementById('containerGrafico');
        const containerRelatorio = document.getElementById('containerRelatorio');
        const opcaoTipoGrafico = document.getElementById('opcaoTipoGrafico');
        
        if (tipo === 'relatorio') {
            containerGrafico.style.display = 'none';
            containerRelatorio.style.display = 'block';
            opcaoTipoGrafico.style.display = 'none';
            atualizarRelatorio();
        } else {
            containerGrafico.style.display = 'block';
            containerRelatorio.style.display = 'none';
            
            if (tipo === 'grafico') {
                opcaoTipoGrafico.style.display = 'block';
                criarGrafico(document.getElementById('tipoGrafico').value);
            } else if (tipo === 'pizza') {
                opcaoTipoGrafico.style.display = 'none';
                criarGraficoPizza();
            }
        }
    }

    // Função para criar o relatório em tabela
    function atualizarRelatorio() {
        const tbody = document.getElementById('relatorioBody');
        tbody.innerHTML = '';
        
        let total2025 = 0;
        let total2026 = 0;
        
        // Criar linhas para cada mês (garantindo que abril e todos os meses estejam incluídos)
        for (let i = 0; i < 12; i++) {
            const venda2025 = vendas2025Data[i] || 0;
            const venda2026 = vendas2026Data[i] || 0;
            const variacao = venda2025 > 0 ? ((venda2026 - venda2025) / venda2025 * 100).toFixed(2) : 'N/A';
            
            total2025 += venda2025;
            total2026 += venda2026;
            
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${mesesNomes[i]}</td>
                <td class="text-right">${formatMoeda(venda2025)}</td>
                <td class="text-right">${formatMoeda(venda2026)}</td>
                <td class="text-right">${variacao}%</td>
            `;
            tbody.appendChild(row);
        }
        
        // Adicionar linha de total
        const variacaoTotal = total2025 > 0 ? ((total2026 - total2025) / total2025 * 100).toFixed(2) : 'N/A';
        const rowTotal = document.createElement('tr');
        rowTotal.className = 'font-weight-bold table-active';
        rowTotal.innerHTML = `
            <td>Total</td>
            <td class="text-right">${formatMoeda(total2025)}</td>
            <td class="text-right">${formatMoeda(total2026)}</td>
            <td class="text-right">${variacaoTotal}%</td>
        `;
        tbody.appendChild(rowTotal);
    }

    // Função para formatar valores em moeda brasileira
    function formatMoeda(valor) {
        return new Intl.NumberFormat('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        }).format(valor);
    }

    // Função para criar o gráfico
    function criarGrafico(tipo) {
        const ctx = document.getElementById('graficoVendasAnuais').getContext('2d');

        if (chartInstance) {
            chartInstance.destroy(); // Destrói o gráfico anterior
        }

        // Criando o gráfico
        chartInstance = new Chart(ctx, {
            type: tipo,
            data: {
                labels: mesesNomes, // Usando nomes de meses em vez de números
                datasets: [
                    {
                        label: 'Vendas 2025',
                        data: vendas2025Data,
                        borderColor: 'green',
                        backgroundColor: 'rgba(0, 128, 0, 0.2)',
                        fill: tipo === 'bar',
                        borderWidth: 2
                    },
                    {
                        label: 'Vendas 2026',
                        data: vendas2026Data,
                        borderColor: 'blue',
                        backgroundColor: 'rgba(0, 0, 255, 0.2)',
                        fill: tipo === 'bar',
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Comparativo de Vendas Anuais (2025 vs 2026)'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) label += ': ';
                                if (context.parsed.y !== null) {
                                    label += formatMoeda(context.parsed.y);
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
                                return formatMoeda(value);
                            }
                        }
                    }
                }
            }
        });
    }

    // Função para criar gráfico de pizza
    function criarGraficoPizza() {
        const ctx = document.getElementById('graficoVendasAnuais').getContext('2d');

        if (chartInstance) {
            chartInstance.destroy(); // Destrói o gráfico anterior
        }

        // Calcular valores totais por mês (2025 + 2026)
        const dadosCombinados = vendas2025Data.map((valor, idx) => 
            (valor || 0) + (vendas2026Data[idx] || 0)
        );

        // Cores para o gráfico de pizza
        const cores = [
            'rgba(255, 99, 132, 0.7)',
            'rgba(54, 162, 235, 0.7)',
            'rgba(255, 206, 86, 0.7)',
            'rgba(75, 192, 192, 0.7)',
            'rgba(153, 102, 255, 0.7)',
            'rgba(255, 159, 64, 0.7)',
            'rgba(255, 99, 132, 0.7)',
            'rgba(54, 162, 235, 0.7)',
            'rgba(255, 206, 86, 0.7)',
            'rgba(75, 192, 192, 0.7)',
            'rgba(153, 102, 255, 0.7)',
            'rgba(255, 159, 64, 0.7)'
        ];

        // Criando o gráfico de pizza
        chartInstance = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: mesesNomes,
                datasets: [{
                    data: dadosCombinados,
                    backgroundColor: cores,
                    borderColor: cores.map(cor => cor.replace('0.7', '1')),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Distribuição de Vendas por Mês (Total 2025+2026)'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const valor = context.raw;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentual = ((valor / total) * 100).toFixed(1);
                                return `${label}: ${formatMoeda(valor)} (${percentual}%)`;
                            }
                        }
                    },
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
    }

    // Atualiza o tipo do gráfico (linha ou barra)
    function atualizarTipoGrafico(tipoSelecionado) {
        criarGrafico(tipoSelecionado);
    }

    // Carregar o gráfico ao carregar a página
    document.addEventListener('DOMContentLoaded', function () {
        criarGrafico('line'); // Carrega o gráfico como linha por padrão
    });
</script>
@endsection