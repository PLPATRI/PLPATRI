@section('title', 'Etiquetas - Combrim')
@extends('components.main')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Main content -->
            <section class="content">
                <div class="col-xxl-12 p-0">
                    <div class="box">
                        <div class="box-header with-border d-flex align-items-center justify-content-between">
                            <h4 class="box-title">Relatórios</h4>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                 <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                           <th>Mensal</th>  

<?php
// Função para obter o IPv4 local usando o comando ipconfig no Windows
function get_ipv4_from_ipconfig() {
    // Executa o comando ipconfig e captura a saída
    ob_start();
    system('ipconfig');
    $output = ob_get_clean();

    // Procura pela linha que contém o IPv4
    preg_match('/IPv4[^\r\n]*:\s*([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/', $output, $matches);

    // Retorna o IP encontrado, ou uma mensagem de erro se não encontrar
    return isset($matches[1]) ? $matches[1] : 'IP não encontrado';
}

// Obtém o IP do sistema local
$ip_ipv4 = get_ipv4_from_ipconfig();

// Exibe o IP
 "<p>$ip_ipv4</p>";
?>



                                        <th><a href="http://{{ $ip_ipv4 }}/mensal.php" target="_blank">Ver Mensal</a></th>
										   
                                            
                                        </tr>
                                         <tr>
                                           <th>Anual</th>                                           
                                            <th><a href="http://{{ $ip_ipv4 }}/anual.php" target="_blank">Ver Anual</a></th>
                                        </tr>
                                        
                                         <tr>
                                           <th>Curva ABC</th>                                           
                                            <th><a href="http://{{ $ip_ipv4 }}/curvaabc.php" target="_blank">Ver Curva ABC</a></th>
                                        </tr>
                                        
                                         <tr>
                                           <th>Clientes que mais Compraram</th>                                           
                                            <th><a href="http://{{ $ip_ipv4 }}/relatorioclientes.php" target="_blank">Ver Clientes que mais Compraram</a></th>
                                        </tr>
                                        
                                         <tr>
                                           <th>Itens mais Vendidos</th>                                           
                                            <th><a href="http://{{ $ip_ipv4 }}/itensmaisvendidos.php" target="_blank">Ver Itens mais Vendidos</a></th>
                                        </tr>
										 <th>Vendedor</th>                                           
                                            <th><a href="http://{{ $ip_ipv4 }}/vendedor.php" target="_blank">Ver Vendedor que mais vendeu</a></th>
                                        </tr>
										<th>Funil de Vendas</th>                                           
                                            <th><a href="http://{{ $ip_ipv4 }}/funilvendas.php" target="_blank">Ver Funil de vendas</a></th>
                                        </tr>
										
										 <th>Gauge Metas</th>                                           
                                            <th><a href="http://{{ $ip_ipv4 }}/gaugemetas.php" target="_blank">Ver Gauge Metas</th>
                                        </tr>
										
										<th>Indicadores de Desempenho (KPIs - Key Performance Indicators</th>                                           
                                            <th><a href="http://{{ $ip_ipv4 }}/desempenho.php" target="_blank">Ver Indicadores de Desempenho (KPIs - Key Performance Indicators</th>
                                        </tr>
										
										
                                    </thead>
                                </table>
                            </div>

                            <!-- Pagination Links -->

                        </div>
                  
                        <!-- /.box-body -->
                    </div>
                </div>
                <!-- /.content -->
            </section>
        </div>
    </div>

    <!-- Etikto Admin App -->
    <script src="js/jquery.smartmenus.js"></script>
    <script src="js/menus.js"></script>
    <script src="js/template.js"></script>
    <script src="js/pages/dashboard2.js"></script>
    <script src="js/pages/calendar.js"></script>
@endsection
