@section('title', 'Configurações - Combrim')

@extends('components.main')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Main content -->
            <section class="content">
                <div class="row justify-content-center">
                    <div class="col-lg-9 col-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h4 class="box-title">Configurações</h4>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <livewire:configuracoes-tabelas />
                                <hr>
                                <div class="d-flex justify-content-between align-items-center my-4">
                                    <h5>Alterar dados cadastrais de vendedores</h5>
                                    <a data-bs-toggle="modal" data-bs-target=".vendedores-modal"
                                        class="btn btn-primary-light">
                                        Vendedores
                                    </a>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <h5>Apagar banco de dados</h5>
                                    <a data-bs-toggle="modal" data-bs-target=".select-delete-modal" class="btn btn-danger">
                                        Apagar
                                    </a>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
    </div>


    <!-- /.modal confirm -->
    <div class="modal fade confirm-modal" tabindex="-1" role="dialog" aria-labelledby="confirmModal" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Confirmar alteração?</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <i class="fas fa-warning" style="font-size: 50px; color:rgb(255, 196, 0);"></i>
                                <h4 class="text-center">Ao confirmar, todas as tabelas do sistema serão alteradas e
                                    passaram a mostrar ${value} de itens.</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-no" data-bs-dismiss="modal" aria-label="Close"
                        class="btn btn-danger me-1">
                        <i class="fas fa-trash"></i> Não
                    </button>
                    <button type="submit" id="btn-yes" class="btn btn-success">
                        <i class="fas fa-check"></i> Sim
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade delete-modal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Confirmar exclusão dessa tabela no banco de
                        dados?</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <i class="fas fa-warning" style="font-size: 50px; color:rgb(255, 196, 0);"></i>
                                <h4 class="text-center">Ao confirmar, todas as informações do sua tabela no banco
                                    serão deletadas!</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-no" data-bs-dismiss="modal" aria-label="Close"
                        class="btn btn-danger me-1">
                        <i class="fas fa-close"></i> Não
                    </button>
                    <button type="submit" id="btn-yes" class="btn btn-success">
                        <i class="fas fa-trash"></i> Sim
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade select-delete-modal" tabindex="-1" role="dialog" aria-labelledby="selectDeleteModal"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Selecione as tabelas que você deseja excluir
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('limpa.tabelas.deletar') }}" method="post" id="delete-form">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="mx-10">
                                        <input type="checkbox" name="clientes" id="clientes" class="filled-in">
                                        <label for="clientes">Clientes</label>
                                    </div>
                                    <div class="mx-10">
                                        <input type="checkbox" name="vendedores" id="vendedores" class="filled-in">
                                        <label for="vendedores">Vendedores</label>
                                    </div>
                                    <div class="mx-10">
                                        <input type="checkbox" name="pedidos" id="pedidos" class="filled-in">
                                        <label for="pedidos">Pedidos</label>
                                    </div>
                                    <div class="mx-10">
                                        <input type="checkbox" name="estoque" id="estoque"
                                            class="filled-in">
                                        <label for="estoque">Estoque</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                         <!-- Select de Fornecedores (Inicialmente escondido) -->
                         <div class="row justify-content-center mt-3" id="fornecedores-select" style="display: none;">
                            <div class="col-6">
                                <select name="fornecedor" id="fornecedor-select" class="form-control">
                                    <option value="todos">Todos os Fornecedores</option>
                                    @foreach($fornecedores as $fornecedor)
                                    <option value="{{ $fornecedor->id }}">{{ $fornecedor->razao_social }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-danger me-1">
                            <i class="fas fa-close"></i> Não
                        </button>
                        <button type="submit" id="confirm-delete-button" class="btn btn-success">
                            <i class="fas fa-trash"></i> Sim
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal vendedores -->
    <div class="modal fade vendedores-modal" tabindex="-1" role="dialog" aria-labelledby="vendedorModal"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Vendedores</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" class="form" action="{{ route('vendedores.put') }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <div class="box">
                                    <!-- /.box-header -->

                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">Vendedor</label>
                                                    <select name="usuario_selecionado" class="form-select">
                                                        @foreach ($vendedores as $vendedor)
                                                            <option value="{{ $vendedor->id }}">{{ $vendedor->usuario }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">Nome</label>
                                                    <input type="text" class="form-control" name="usuario"
                                                        placeholder="Nome">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">Senha</label>
                                                    <input type="text" name="senha" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- /.box -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-danger me-1">
                            <i class="fas fa-close"></i> Fechar
                        </button>
                        <button type="submit" class="btn btn-success me-1">
                            <i class="fas fa-check"></i> Confirmar
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- /.modal value unic -->
    <div class="modal fade value-product-modal" tabindex="-1" role="dialog" aria-labelledby="valueProductModal"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Alterar valor unitário do fornecedor</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="box">
                                <!-- /.box-header -->
                                <form class="form" action="">
                                    <div class="box-body">
                                        <div class="row">
                                            <h5>Selecione o fornecedor</h5>
                                            <hr class="my-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">Fornecedor</label>
                                                    <select class="form-select">
                                                        <option>Fornecedor 1</option>
                                                        <option>Fornecedor 2</option>
                                                        <option>Fornecedor 3</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <input type="number" class="form-control" placeholder="R$0,00">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.box -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-danger me-1">
                        <i class="fas fa-close"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Salvar
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- Inclua o jQuery primeiro -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Depois, inclua o Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <!-- Vendor JS -->
    <script src="js/vendors.min.js"></script>
    <script src="js/pages/chat-popup.js"></script>
    <script src="https://etikto-admin-dashboard.multipurposethemes.com/bs5/assets/icons/feather-icons/feather.min.js">
    </script>

    <script
        src="https://etikto-admin-dashboard.multipurposethemes.com/bs5/assets/vendor_components/jquery-knob/js/jquery.knob.js">
    </script>
    <script src="https://etikto-admin-dashboard.multipurposethemes.com/bs5/assets/icons/feather-icons/feather.min.js">
    </script>
    <script
        src="https://etikto-admin-dashboard.multipurposethemes.com/bs5/assets/vendor_components/bootstrap-select/dist/js/bootstrap-select.js">
    </script>
    <script
        src="https://etikto-admin-dashboard.multipurposethemes.com/bs5/assets/vendor_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.js">
    </script>
    <script
        src="https://etikto-admin-dashboard.multipurposethemes.com/bs5/assets/vendor_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js">
    </script>
    <script
        src="https://etikto-admin-dashboard.multipurposethemes.com/bs5/assets/vendor_components/select2/dist/js/select2.full.js">
    </script>
    <script src="https://etikto-admin-dashboard.multipurposethemes.com/bs5/assets/vendor_components/raphael/raphael.min.js">
    </script>
    <script
        src="https://etikto-admin-dashboard.multipurposethemes.com/bs5/assets/vendor_components/morris.js/morris.min.js">
    </script>
    <script
        src="https://etikto-admin-dashboard.multipurposethemes.com/bs5/assets/vendor_components/apexcharts-bundle/dist/apexcharts.js">
    </script>
    <script
        src="https://etikto-admin-dashboard.multipurposethemes.com/bs5/assets/vendor_plugins/input-mask/jquery.inputmask.js">
    </script>
    <script
        src="https://etikto-admin-dashboard.multipurposethemes.com/bs5/assets/vendor_plugins/input-mask/jquery.inputmask.date.extensions.js">
    </script>
    <script
        src="https://etikto-admin-dashboard.multipurposethemes.com/bs5/assets/vendor_plugins/input-mask/jquery.inputmask.extensions.js">
    </script>
    <script
        src="https://etikto-admin-dashboard.multipurposethemes.com/bs5/assets/vendor_components/moment/min/moment.min.js">
    </script>
    <script
        src="https://etikto-admin-dashboard.multipurposethemes.com/bs5/assets/vendor_components/bootstrap-daterangepicker/daterangepicker.js">
    </script>
    <script
        src="https://etikto-admin-dashboard.multipurposethemes.com/bs5/assets/vendor_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js">
    </script>
    <script
        src="https://etikto-admin-dashboard.multipurposethemes.com/bs5/assets/vendor_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js">
    </script>
    <script
        src="https://etikto-admin-dashboard.multipurposethemes.com/bs5/assets/vendor_plugins/timepicker/bootstrap-timepicker.min.js">
    </script>
    <script src="https://etikto-admin-dashboard.multipurposethemes.com/bs5/assets/vendor_plugins/iCheck/icheck.min.js">
    </script>

    <!-- Etikto Admin App -->
    <script src="js/jquery.smartmenus.js"></script>
    <script src="js/menus.js"></script>
    <script src="js/template.js"></script>
    <script src="js/pages/dashboard2.js"></script>
    <script src="js/pages/calendar.js"></script>
    <script src="js/pages/advanced-form-element.js"></script>


    <script>
        // Seleciona o input e o botão de validação
        const quantityInput = document.getElementById('quantityInput');
        const validateButton = document.getElementById('validateButton');

        // Função para mostrar o botão ao alterar o valor do input
        quantityInput.addEventListener('input', function() {
            validateButton.style.display = 'inline'; // Exibe o botão
        });

        // Função de validação
        function validate() {
            const value = quantityInput.value;
            validateButton.style.display = 'none'; // Oculta o botão após a validação
        }
    </script>


    <script>
        function toggleDiv() {
            const checkbox = document.getElementById("estoque");
            const div = document.getElementById("toggle-div");

            if (checkbox.checked) {
                div.style.display = "block";
            } else {
                div.style.display = "none";
            }
        }
    </script>

    <script>
        document.getElementById('open-second-modal').addEventListener('click', function() {
            // Fechar a primeira modal
            const firstModal = new bootstrap.Modal(document.querySelector('.select-delete-modal'));
            firstModal.hide();

            // Abrir a segunda modal
            const secondModal = new bootstrap.Modal(document.querySelector('.delete-modal'));
            secondModal.show();
        });
    </script>

    <script>
       document.addEventListener('DOMContentLoaded', function () {

const estoqueCheckbox = document.getElementById('estoque');
const fornecedoresSelectDiv = document.getElementById('fornecedores-select');
const fornecedorSelect = document.getElementById('fornecedor-select');
 const form = document.getElementById('delete-form');
 const confirmDeleteButton = document.getElementById('confirm-delete-button');


estoqueCheckbox.addEventListener('change', function () {
    fornecedoresSelectDiv.style.display = this.checked ? 'flex' : 'none';
});


 confirmDeleteButton.addEventListener('click', function(event) {
        event.preventDefault(); // Impede o envio padrão do formulário
         let tabelasSelecionadas = [];
        
        if (document.getElementById('clientes').checked) {
            tabelasSelecionadas.push('Clientes');
        }
        if (document.getElementById('vendedores').checked) {
            tabelasSelecionadas.push('Vendedores');
        }
        if (document.getElementById('pedidos').checked) {
            tabelasSelecionadas.push('Pedidos');
        }
        if (document.getElementById('estoque').checked) {
            tabelasSelecionadas.push('Estoque');
        }
        let fornecedorSelecionado = fornecedorSelect.value;
        
        if (tabelasSelecionadas.length === 0){
             alert('Selecione ao menos uma tabela para excluir!');
             return;
        }
        let text = `Tem certeza que deseja excluir todas as informações da(s) tabela(s) `
        
         tabelasSelecionadas.forEach((tabela, index)=>{
            text += tabela;
            if(index !== tabelasSelecionadas.length - 1){
                text += ', '
            }
        });
        
        
       if(tabelasSelecionadas.includes('Estoque') && fornecedorSelecionado !== 'todos'){
          text += ' do fornecedor ' + fornecedorSelect.options[fornecedorSelect.selectedIndex].text
       }
        text += '?';
   if(confirm(text)){
       form.submit();
   }
 });
});
    </script>
@endsection
