<?php 


// Conectar ao banco de dados
$servername = "localhost";
$username = "root";  
$password = "";      
$dbname = "sistema";  

// Criar conexão
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificar conexão
if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}
echo "Conectado com sucesso!";

// Inicializar variáveis com valores padrão para 2025
$mes_01_25 = $mes_02_25 = $mes_03_25 = $mes_04_25 = $mes_05_25 = $mes_06_25 = 0;
$mes_07_25 = $mes_08_25 = $mes_09_25 = $mes_10_25 = $mes_11_25 = $mes_12_25 = 0;

// Consultas SQL para 2025
$sql_0125 = "SELECT sum(valor) AS soma from pedidos where data between '2025-01-01' and '2025-01-31'";
$sql_0225 = "SELECT sum(valor) AS soma from pedidos where data between '2025-02-01' and '2025-02-28'";
$sql_0325 = "SELECT sum(valor) AS soma from pedidos where data between '2025-03-01' and '2025-03-31'";
$sql_0425 = "SELECT sum(valor) AS soma from pedidos where data between '2025-04-01' and '2025-04-30'";
$sql_0525 = "SELECT sum(valor) AS soma from pedidos where data between '2025-05-01' and '2025-05-31'";
$sql_0625 = "SELECT sum(valor) AS soma from pedidos where data between '2025-06-01' and '2025-06-30'";
$sql_0725 = "SELECT sum(valor) AS soma from pedidos where data between '2025-07-01' and '2025-07-31'";
$sql_0825 = "SELECT sum(valor) AS soma from pedidos where data between '2025-08-01' and '2025-08-31'";
$sql_0925 = "SELECT sum(valor) AS soma from pedidos where data between '2025-09-01' and '2025-09-30'";
$sql_1025 = "SELECT sum(valor) AS soma from pedidos where data between '2025-10-01' and '2025-10-31'";
$sql_1125 = "SELECT sum(valor) AS soma from pedidos where data between '2025-11-01' and '2025-11-30'";
$sql_1225 = "SELECT sum(valor) AS soma from pedidos where data between '2025-12-01' and '2025-12-31'";



// Consultas e atribuições das variáveis (para todos os meses de 2025)
$result_TESTE = mysqli_query($conn, $sql_0125);
if ($result_TESTE) {
    $mes01_25 = mysqli_fetch_row($result_TESTE);
    if ($mes01_25[0] !== null) {
        $mes_01_25 = $mes01_25[0];
    }
}


// Consultas e atribuições das variáveis (para todos os meses de 2025)
$result_TESTE = mysqli_query($conn, $sql_0225);
if ($result_TESTE) {
    $mes02_25 = mysqli_fetch_row($result_TESTE);
    if ($mes02_25[0] !== null) {
        $mes_02_25 = $mes02_25[0];
    }
}

$result_TESTE = mysqli_query($conn, $sql_0325);
if ($result_TESTE) {
    $mes03_25 = mysqli_fetch_row($result_TESTE);
    if ($mes03_25[0] !== null) {
        $mes_03_25 = $mes03_25[0];
    }
}

$result_TESTE = mysqli_query($conn, $sql_0425);
if ($result_TESTE) {
    $mes04_25 = mysqli_fetch_row($result_TESTE);
    if ($mes04_25[0] !== null) {
        $mes_04_25 = $mes04_25[0];
    }
}

$result_TESTE = mysqli_query($conn, $sql_0525);
if ($result_TESTE) {
    $mes05_25 = mysqli_fetch_row($result_TESTE);
    if ($mes05_25[0] !== null) {
        $mes_05_25 = $mes05_25[0];
    }
}

$result_TESTE = mysqli_query($conn, $sql_0625);
if ($result_TESTE) {
    $mes06_25 = mysqli_fetch_row($result_TESTE);
    if ($mes06_25[0] !== null) {
        $mes_06_25 = $mes06_25[0];
    }
}

$result_TESTE = mysqli_query($conn, $sql_0725);
if ($result_TESTE) {
    $mes07_25 = mysqli_fetch_row($result_TESTE);
    if ($mes07_25[0] !== null) {
        $mes_07_25 = $mes07_25[0];
    }
}

$result_TESTE = mysqli_query($conn, $sql_0825);
if ($result_TESTE) {
    $mes08_25 = mysqli_fetch_row($result_TESTE);
    if ($mes08_25[0] !== null) {
        $mes_08_25 = $mes08_25[0];
    }
}

$result_TESTE = mysqli_query($conn, $sql_0925);
if ($result_TESTE) {
    $mes09_25 = mysqli_fetch_row($result_TESTE);
    if ($mes09_25[0] !== null) {
        $mes_09_25 = $mes09_25[0];
    }
}

$result_TESTE = mysqli_query($conn, $sql_1025);
if ($result_TESTE) {
    $mes10_25 = mysqli_fetch_row($result_TESTE);
    if ($mes10_25[0] !== null) {
        $mes_10_25 = $mes10_25[0];
    }
}

$result_TESTE = mysqli_query($conn, $sql_1125);
if ($result_TESTE) {
    $mes11_25 = mysqli_fetch_row($result_TESTE);
    if ($mes11_25[0] !== null) {
        $mes_11_25 = $mes11_25[0];
    }
}

$result_TESTE = mysqli_query($conn, $sql_1225);
if ($result_TESTE) {
    $mes12_25 = mysqli_fetch_row($result_TESTE);
    if ($mes12_25[0] !== null) {
        $mes_12_25 = $mes12_25[0];
    }
}

// Dados para o gráfico de vendas mensais
$data = [
    ['Mês', 'Vendas'],
    ['Jan', (int)$mes_01_25],
    ['Fev', (int)$mes_02_25],
    ['Mar', (int)$mes_03_25],
    ['Abr', (int)$mes_04_25],
    ['Mai', (int)$mes_05_25],
    ['Jun', (int)$mes_06_25],
    ['Jul', (int)$mes_07_25],
    ['Ago', (int)$mes_08_25],
    ['Set', (int)$mes_09_25],
    ['Out', (int)$mes_10_25],
    ['Nov', (int)$mes_11_25],
    ['Dez', (int)$mes_12_25],
];
$jsonData = json_encode($data);

// Consultar vendas por região
$sql = "SELECT SUBSTRING_INDEX(endereco, ' - ', -1) AS regiao, SUM(valor) AS total_vendas
        FROM pedidos
        GROUP BY regiao";
$result = mysqli_query($conn, $sql);

$vendasPorRegiao = [];
$totalVendasBrasil = 0;

if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $vendasPorRegiao[$row['regiao']] = $row['total_vendas'];
        $totalVendasBrasil += $row['total_vendas'];
    }
} else {
    echo "Nenhum resultado encontrado!";
}

mysqli_close($conn); // Fechar a conexão
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório Gráfico</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <style>
        /* Estilos para o layout e gráficos */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background-color: #ffffff; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; flex-direction: column; }
        h1 { text-align: center; margin-bottom: 20px; color: #333; }
        #logo { margin-top: 20px; width: 150px; display: block; margin-left: auto; margin-right: auto; }
        label { font-size: 14px; margin-top: 20px; margin-bottom: 10px; color: #555; }
        select { padding: 8px 12px; font-size: 14px; border: 1px solid #ddd; border-radius: 5px; cursor: pointer; outline: none; }
        .chart-container { display: flex; justify-content: space-between; gap: 20px; flex-wrap: wrap; width: 100%; max-width: 1200px; margin-top: 30px; }
        #chart_div { flex: 1 1 100%; height: 400px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); background-color: #ffffff; }
        .chart-container > div { min-width: 400px; height: 400px; }
        @media (max-width: 768px) { .chart-container { flex-direction: column; gap: 20px; } #chart_div { width: 100%; } }
    </style>
</head>
<body>

    <img src="sys_erp/public/imgs/logo.jpg" id="logo" alt="Logotipo">

    <h1>Relatório Gráfico - Vendas Mensais de 2025</h1>
    
    <label for="chart_type">Escolha o tipo de gráfico:</label>
    <select id="chart_type" onchange="changeChartType()">
        <option value="BarChart">Bar Chart</option>
        <option value="LineChart">Line Chart</option>    
        <option value="ColumnChart">ColumnChart</option>
        <option value="AreaChart">AreaChart</option>
        <option value="ScatterChart">ScatterChart</option>
    </select>

    <div class="chart-container">
        <!-- Gráfico de Vendas Mensais -->
        <div id="chart_div"></div>
    </div>

    <script>
        // Google Charts para o gráfico de vendas mensais
        google.charts.load('current', {packages: ['corechart', 'bar']});

        function drawChart(chartType) {
            var data = google.visualization.arrayToDataTable(<?php echo $jsonData; ?>);
            var options = {
                title: 'Vendas Mensais',
                chartArea: {width: '60%'},
                hAxis: {title: 'Vendas', minValue: 0},
                vAxis: {
                    title: 'Mês',
                    slantedText: true,
                    slantedTextAngle: 45,
                    textStyle: {fontSize: 12}
                },
                bar: {groupWidth: '75%'},
                legend: {position: 'none'}
            };

            var chart;
            switch (chartType) {
                case 'BarChart':
                    chart = new google.visualization.BarChart(document.getElementById('chart_div'));
                    break;
                case 'LineChart':
                    chart = new google.visualization.LineChart(document.getElementById('chart_div'));
                    break;                
                case 'ColumnChart':
                    chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
                    break;
                case 'AreaChart':
                    chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
                    break;
                case 'ScatterChart':
                    chart = new google.visualization.ScatterChart(document.getElementById('chart_div'));
                    break;
                default:
                    chart = new google.visualization.BarChart(document.getElementById('chart_div'));
            }

            chart.draw(data, options);
        }

        google.charts.setOnLoadCallback(function() {
            drawChart('BarChart');
        });

        function changeChartType() {
            var chartType = document.getElementById('chart_type').value;
            drawChart(chartType);
        }
    </script>

</body>
</html>
