
@section('title', 'Clientes - Combrim')
@extends('components.main')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Main content -->
            <section class="content">
                <div class="row justify-content-center">
                    <div class="col-lg-9 col-12">
                        <div class="box bg-white">
                            <div class="box-header with-border">
                                <h4 class="box-title">Cadastro de Cliente</h4>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body ">
                                <!-- Nav tabs -->
                                <div class="vtabs">
                                    <ul class="nav nav-tabs tabs-vertical" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#cpf" role="tab">
                                                <span class="hidden-sm-up">
                                                    <i class="fas fa-user"></i>
                                                </span>
                                                <span class="hidden-xs-down">CPF</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#cpnj" role="tab">
                                                <span class="hidden-sm-up">
                                                    <i class="fas fa-business"></i>
                                                </span>
                                                <span class="hidden-xs-down">CNPJ</span>
                                            </a>
                                        </li>
                                    </ul>

                                    <style>
                                        .is-invalid {
                                            border: 1px solid red;
                                            border-radius: 8px;
                                        }
                                    </style>
                                    <!-- Tab panes -->
                                    <div class="tab-content w-p100">
                                        <div class="tab-pane active" id="cpf" role="tabpanel">
                                            <div class="row">
                                                <div class="col-12">
                                                    <form class="form" id="envia-dados"
                                                        action="{{ route('clientes.cadastrar.post') }}" method="post">
                                                        @csrf
                                                        <div class="box-body">
                                                            <div class="row">
                                                                <input type="hidden" name="tipo_documento" value="CPF">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Nome</label>
                                                                        <input type="text" name="razao_social"
                                                                            class="form-control" placeholder="Nome">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Documento (CPF)</label>
                                                                        <input type="text" name="numero_documento"
                                                                            class="form-control"
                                                                            placeholder="123.456.789-10" id="numero_documento_cpf">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Telefone de
                                                                            Contato</label>
                                                                        <input type="text" name="telefone"
                                                                            class="form-control"
                                                                            placeholder="(00) 9999-9999"
                                                                            oninput="maskPhone(this)">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Email</label>
                                                                        <input type="email" name="email"
                                                                            class="form-control"
                                                                            placeholder="name@mail.com">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Segundo Email</label>
                                                                        <input type="text" name="second_email"
                                                                            class="form-control"
                                                                            placeholder="razaosocial@mail.com">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label">CEP</label>
                                                                        <input type="text" name="cep" id="cep_cpf"
                                                                            class="form-control" placeholder="9999999">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Bairro</label>
                                                                        <input type="text" name="bairro" id="bairro_cpf"
                                                                            class="form-control" placeholder="Bairro"
                                                                            readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Número</label>
                                                                        <input type="text" name="numero" id="numero_cpf"
                                                                            class="form-control" placeholder="Número">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Endereço</label>
                                                                        <input type="text" name="endereco"
                                                                            id="endereco_cpf" class="form-control"
                                                                            placeholder="Endereço" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Cidade</label>
                                                                        <input type="text" name="cidade" id="cidade_cpf"
                                                                            class="form-control" placeholder="Cidade"
                                                                            readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="form-label">UF</label>
                                                                        <input type="text" name="uf" id="uf_cpf"
                                                                            class="form-control" placeholder="UF" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group">
                                                                    <label class="form-label">Observações</label>
                                                                    <textarea name="observacoes" class="form-control" placeholder="Digite observações aqui..."></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /.box-body -->

                                                    </form>
                                                    <div class="box-footer">
                                                        <button type="button" class="btn btn-danger me-1">
                                                            <i class="fas fa-trash"></i> Cancelar
                                                        </button>
                                                        <button type="submit" id="submit-button"
                                                            class="btn btn-success">
                                                            <i class="fas fa-save"></i> Salvar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="cpnj" role="tabpanel">
                                            <div class="row">
                                                <div class="col-12">
                                                    <form class="form" action="{{ route('clientes.cadastrar.post') }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('POST')
                                                        <div class="box-body">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <input type="hidden" name="tipo_documento"
                                                                        value="CNPJ">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Razão
                                                                            Social</label>
                                                                        <input type="text" name="razao_social"
                                                                            class="form-control"
                                                                            placeholder="Razão Social">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Inscrição
                                                                            Estadual</label>
                                                                        <input type="text"
                                                                            placeholder="Inscrição estadual"
                                                                            name="inscricao_estadual"
                                                                            class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Documento
                                                                            (CNPJ)</label>
                                                                        <input type="text" name="numero_documento"
                                                                            class="form-control"
                                                                            placeholder="12.345.678/001-10" id="numero_documento_cnpj">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Email</label>
                                                                        <input type="text" name="email"
                                                                            class="form-control"
                                                                            placeholder="razaosocial@mail.com">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Segundo Email</label>
                                                                        <input type="text" name="second_email"
                                                                            class="form-control"
                                                                            placeholder="razaosocial@mail.com">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Telefone</label>
                                                                        <input type="text" name="telefone"
                                                                            class="form-control"
                                                                            placeholder="(00) 0000-0000">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Celular</label>
                                                                        <input type="text" name="celular"
                                                                            class="form-control"
                                                                            placeholder="(00) 0000-0000">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label">CEP</label>
                                                                        <input type="text" name="cep"
                                                                            id="cep" class="form-control"
                                                                            placeholder="9999999">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Bairro</label>
                                                                        <input type="text" name="bairro"
                                                                            id="bairro" class="form-control"
                                                                            placeholder="Bairro" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Endereço</label>
                                                                        <input type="text" name="endereco"
                                                                            id="endereco" class="form-control"
                                                                            placeholder="Endereço" readonly>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Número</label>
                                                                        <input type="text" name="numero"
                                                                            id="numero" class="form-control"
                                                                            placeholder="Número">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Cidade</label>
                                                                        <input type="text" name="cidade"
                                                                            id="cidade" class="form-control"
                                                                            placeholder="Cidade" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="form-label">UF</label>
                                                                        <input type="text" name="uf"
                                                                            id="uf" class="form-control"
                                                                            placeholder="UF" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group">
                                                                    <label class="form-label">Observações</label>
                                                                    <textarea name="observacoes" class="form-control" placeholder="Digite observações aqui..."></textarea>
                                                                </div>
                                                            </div>

                                                            <script>
                                                                document.getElementById('cep').addEventListener('blur', function() {
                                                                    var cep = this.value.replace(/\D/g, '');
                                                                    if (cep.length === 8) {
                                                                        fetch(`https://viacep.com.br/ws/${cep}/json/`)
                                                                            .then(response => response.json())
                                                                            .then(data => {
                                                                                if (!data.erro) {
                                                                                    document.getElementById('endereco').value = data.logradouro;
                                                                                    document.getElementById('bairro').value = data.bairro;
                                                                                    document.getElementById('cidade').value = data.localidade;
                                                                                    document.getElementById('uf').value = data.uf;
                                                                                } else {
                                                                                    alert('CEP não encontrado.');
                                                                                }
                                                                            })
                                                                            .catch(error => {
                                                                                console.error('Erro ao buscar CEP:', error);
                                                                            });
                                                                    } else {
                                                                        alert('CEP inválido. Deve conter 8 dígitos.');
                                                                    }
                                                                });
                                                            </script>

                                                            <div class="row">

                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Transportadora</label>
                                                                        <input type="text" name="transportadora"
                                                                            class="form-control"
                                                                            placeholder="Nome da transportadora">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Telefone da
                                                                            Transportadora</label>
                                                                        <input type="text" name="numero_transportadora"
                                                                            class="form-control"
                                                                            placeholder="Telefone da transportadora">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Resposável da
                                                                            Transportadora</label>
                                                                        <input type="text"
                                                                            name="responsavel_transportadora"
                                                                            class="form-control"
                                                                            placeholder="Resposável da Transportadora">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /.box-body -->

                                                    </form>
                                                    <div class="box-footer">
                                                        <button type="button" class="btn btn-danger me-1">
                                                            <i class="fas fa-trash"></i> Cancelar
                                                        </button>
                                                        <button type="submit" id="submit-button-cnpj"
                                                            class="btn btn-success">
                                                            <i class="fas fa-save"></i> Salvar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#submit-button').on('click', function() {
                let allFilled = true;
                $('.form-control').each(function() {
                    if ($(this).is(':hidden') || $(this).val().trim() !== '') {
                        $(this).removeClass('is-invalid');
                    } else {
                        allFilled = false;
                        $(this).addClass('is-invalid');
                    }
                });

                if (!allFilled) {
                    alert('Todos os campos devem ser preenchidos.');
                } else {
                    $('#envia-dados').submit();

                }
            });
        });

        $(document).ready(function() {
            $('#cep_cpf').on('blur', function() {
                var cep = $(this).val().replace(/\D/g, '');
                if (cep.length === 8) {
                    $.getJSON(`https://viacep.com.br/ws/${cep}/json/`, function(data) {
                        if (!data.erro) {
                            $('#endereco_cpf').val(data.logradouro);
                            $('#bairro_cpf').val(data.bairro);
                            $('#cidade_cpf').val(data.localidade);
                            $('#uf_cpf').val(data.uf);
                        } else {
                            alert('CEP não encontrado.');
                        }
                    }).fail(function() {
                        alert('Erro ao buscar o CEP.');
                    });
                } else {
                    alert('CEP inválido. Deve conter 8 dígitos.');
                }
            });
        });


        $(document).ready(function() {
            $('#submit-button-cnpj').on('click', function(event) {
                event.preventDefault();
                let allFilled = true;

                $('.form-control').each(function() {
                    if ($(this).is(':visible') && $(this).val().trim() === '') {
                        allFilled = false;
                        $(this).addClass('is-invalid');
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                if (!allFilled) {
                    alert('Todos os campos devem ser preenchidos.');
                } else {
                    $('.form').submit();
                }
            });
        });

        $('input[id="numero_documento_cpf"]').mask('000.000.000-00');

        $('input[id="numero_documento_cnpj"]').mask('00.000.000/0000-00');

        $('input[name="telefone"]').mask('(00) 0000-0000');

        $('input[name="numero_transportadora"]').mask('(00) 0000-0000');

        $('input[name="celular"]').mask('(00) 00000-0000');

    </script>
@endsection
