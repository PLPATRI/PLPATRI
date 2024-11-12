@section('title', 'Vendedores - Combrim')

@extends('components.main')
@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Main content -->
            <section class="content">
                <div class="row justify-content-center">
                    <div class="col-lg-9 col-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h4 class="box-title">Cadastro de vendedor</h4>
                            </div>
                            <!-- /.box-header -->
                            <form class="form" action="{{ route('vendedores.cadastrar.post') }}" method="post">
                                @csrf
                                @method('POST ')
                                <div class="box-body">
                                    <hr class="my-15">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label class="form-label">Nome (Usuário)</label>
                                                <input type="text" name="usuario" class="form-control"
                                                    placeholder="Nome">
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label class="form-label">Senha de acesso</label>
                                                <input type="text" name="senha" class="form-control"
                                                    placeholder="Senha">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <button type="button" class="btn btn-danger me-1">
                                        <i class="fas fa-trash"></i> Cancelar
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save"></i> Salvar
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!-- /.box -->
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
    </div>
@endsection
