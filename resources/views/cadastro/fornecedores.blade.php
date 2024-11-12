@section('title', 'Fornecedores - Combrim')


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
                                <h4 class="box-title">Cadastro de fornecedores</h4>
                            </div>
                            <!-- /.box-header -->
                            <form class="form" action="{{ route('fornecedores.cadastrar.post') }}" method="post">
                                @method('POST')
                                @csrf
                                <div class="box-body">
                                    <hr class="my-15">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Razão Social</label>
                                                <input type="text" name="razao_social" class="form-control"
                                                    placeholder="Razão Social">
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
