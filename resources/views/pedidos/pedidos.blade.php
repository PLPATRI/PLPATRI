@section('title', 'Pedidos - Combrim')

@extends('components.main')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xxl-12">
                        <div class="row">
                            <div class="col-12">
                                <div class="box">
                                    <div class="d-flex align-items-center justify-content-between box-header">
                                        <h4 class="box-title fw-600">Pedidos</h4>
                                        <a href="{{ route('novo.pedidos.get') }}" class="btn btn-success">
                                            Novo pedido <i class="mx-10 fas fa-plus"></i>
                                        </a>
                                    </div>
                                    <livewire:pedidos.pedidos />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
    </div>


    <script>
        const resumoPedidoDiv = document.querySelector('.resumo-pedido');
        const editarPedidoDiv = document.querySelector('.editar-pedido');
        const editarPedidoBtn = document.getElementById('editar-pedido-btn');
        const salvarPedidoBtn = document.getElementById('salvar-pedido-btn');

        editarPedidoBtn.addEventListener('click', function() {
            editarPedidoDiv.classList.remove('hidden');
            resumoPedidoDiv.classList.add('hidden');

        });

        salvarPedidoBtn.addEventListener('click', function() {
            resumoPedidoDiv.classList.remove('hidden');
            editarPedidoDiv.classList.add('hidden');

        });
    </script>

    <script>
        document.getElementById('entrega').addEventListener('click', function() {
            var enderecoInput = document.getElementById('endereco');
            enderecoInput.classList.remove('hidden'); // Remove a classe hidden para exibir o input
        });

        document.getElementById('balcao').addEventListener('click', function() {
            var balcaoInput = document.getElementById('balcao');
            var enderecoInput = document.getElementById('endereco');
            enderecoInput.classList.add('hidden'); // Remove a classe hidden para exibir o input
        });
    </script>

    <!-- Vendor JS -->
    <script src="js/vendors.min.js"></script>
    <script src="js/pages/chat-popup.js"></script>
    <script src="https://etikto-admin-dashboard.multipurposethemes.com/bs5/assets/icons/feather-icons/feather.min.js">
    </script>

    <script
        src="https://etikto-admin-dashboard.multipurposethemes.com/bs5/assets/vendor_components/jquery-knob/js/jquery.knob.js">
    </script>

    <script src="https://etikto-admin-dashboard.multipurposethemes.com/bs5/assets/vendor_components/raphael/raphael.min.js">
    </script>
    <script
        src="https://etikto-admin-dashboard.multipurposethemes.com/bs5/assets/vendor_components/morris.js/morris.min.js">
    </script>
    <script
        src="https://etikto-admin-dashboard.multipurposethemes.com/bs5/assets/vendor_components/apexcharts-bundle/dist/apexcharts.js">
    </script>

    <!-- Etikto Admin App -->
    <script src="js/jquery.smartmenus.js"></script>
    <script src="js/menus.js"></script>
    <script src="js/template.js"></script>
    <script src="js/pages/dashboard2.js"></script>
    <script src="js/pages/calendar.js"></script>
@endsection
