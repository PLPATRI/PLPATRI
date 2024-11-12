@section('title', 'Novo Pedido - Combrim')

@extends('components.main')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <livewire:pedidos.novo-pedido />

    <script>
        window.onload = function() {
            var myModal = new bootstrap.Modal(document.querySelector('.cliente-modal'));
            myModal.show();
        };
    </script>
    <script>
        const customerBtn = document.getElementById('customer');
        const newCustomerBtn = document.getElementById('new-customer');
        const customerDiv = document.querySelector('.customer');
        const newCustomerDiv = document.querySelector('.new-customer');
        const newPedidoCustomerDiv = document.querySelector('.new-pedido-customer');
        const pedidoCustomerDiv = document.querySelector('.pedido-customer');
        const newPedidoCustomerBtn = document.getElementById('new-pedido-customer');
        const newRegisterCustomerDiv = document.querySelector('.tabs-cadastro-cliente');
        const pedidoNewCustomerDiv = document.querySelector('.novo-cliente-pedido');
        const newPedidoNewCustomerBtn = document.getElementById('novo-cliente-proximo');
        const resumoPedidoDiv = document.querySelector('.resumo-pedido');
        const editarPedidoDiv = document.querySelector('.editar-pedido');
        const editarPedidoBtn = document.getElementById('editar-pedido-btn');
        const salvarPedidoBtn = document.getElementById('salvar-pedido-btn');
        const modalElement = document.querySelector('.cliente-modal');

        function closeModal() {
            const modal = bootstrap.Modal.getInstance(modalElement); // Obtém a instância da modal Bootstrap
            modal.hide(); // Fecha a modal
        }

        customerBtn.addEventListener('click', function() {
            // Mostrar customerDiv e esconder newCustomerDiv
            customerDiv.classList.remove('hidden');
            newCustomerDiv.classList.add('hidden');
            closeModal(); // Fechar a modal após a seleção

        });

        newCustomerBtn.addEventListener('click', function() {
            // Mostrar newCustomerDiv e esconder customerDiv
            newCustomerDiv.classList.remove('hidden');
            customerDiv.classList.add('hidden');
            closeModal(); // Fechar a modal após a seleção

        });

        newPedidoCustomerBtn.addEventListener('click', function() {
            // Mostrar newCustomerDiv e esconder customerDiv
            newPedidoCustomerDiv.classList.remove('hidden');
            pedidoCustomerDiv.classList.add('hidden');

        });

        newPedidoNewCustomerBtn.addEventListener('click', function() {
            // Mostrar newCustomerDiv e esconder customerDiv
            pedidoNewCustomerDiv.classList.remove('hidden');
            newRegisterCustomerDiv.classList.add('hidden');

        });
        editarPedidoBtn.addEventListener('click', function() {
            // Mostrar newCustomerDiv e esconder customerDiv
            editarPedidoDiv.classList.remove('hidden');
            resumoPedidoDiv.classList.add('hidden');

        });

        salvarPedidoBtn.addEventListener('click', function() {
            // Mostrar newCustomerDiv e esconder customerDiv
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
