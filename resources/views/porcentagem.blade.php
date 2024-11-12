@section('title', 'Porcentagem - Combrim')

@extends('components.main')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Main content -->
            <section class="content">
                <div class="row justify-content-center">
                    <div class="col-lg-12 col-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h4 class="box-title">Definição da Porcentagem</h4>
                                <p>Aqui você poderá selecionar o fornecedor e pode definir uma porcentagem em cima
                                    de cada produto desse fornecedor</p>
                            </div>
                            <livewire:porcentagem />
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
    </div>



    <script>
        // Função para selecionar ou desmarcar todos os checkboxes
        document.getElementById('basic_checkbox_select_all').addEventListener('change', function() {
            // Pega o estado de seleção do checkbox principal
            let isChecked = this.checked;

            // Seleciona todos os checkboxes dentro da tabela
            let checkboxes = document.querySelectorAll('#example1 tbody input[type="checkbox"]');

            // Aplica o estado do checkbox principal em todos os outros
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = isChecked;
            });
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
