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
                                <h4 class="box-title">Cadastro de produto</h4>
                            </div>
                            <!-- /.box-header -->
                            <form class="form" action="{{ route('produtos.cadastrar.post') }}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="box-body">
                                    <hr class="my-15">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label">Referência</label>
                                                <input type="text" name="referencia" class="form-control"
                                                    placeholder="Referência">
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label class="form-label">Modelo</label>
                                                <input type="text" name="modelo" class="form-control"
                                                    placeholder="Modelo">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Fornecedor</label>
                                                <select name="fornecedor_id" class="form-select">
                                                    @foreach ($data as $fornecedores)
                                                        <option value="{{ $fornecedores['id'] }}">
                                                            {{ $fornecedores['razao_social'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Preço unitário</label>
                                                <input type="text" id="preco_unitario" name="preco_unitario"
                                                    class="form-control" placeholder="R$0,00">
                                            </div>
                                        </div>

                                        <script>
                                            document.getElementById('preco_unitario').addEventListener('input', function(e) {
                                                let value = e.target.value.replace(/\D/g, '');

                                                if (value) {
                                                    let reais = value.slice(0, -4) || '0';
                                                    let centavos = value.slice(-4).padStart(4, '0');

                                                    // Formatação
                                                    let formattedValue = (parseInt(reais) + (parseInt(centavos) / 10000)).toLocaleString('pt-BR', {
                                                        style: 'currency',
                                                        currency: 'BRL',
                                                        minimumFractionDigits: 4,
                                                        maximumFractionDigits: 4
                                                    });

                                                    e.target.value = formattedValue;
                                                } else {
                                                    e.target.value = '';
                                                }
                                            });
                                        </script>


                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="example-date-input" class="form-label">Data</label>
                                                <input class="form-control" name="data" type="date"
                                                    id="example-date-input">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label">Quantidade</label>
                                                <input class="form-control" name="quantidade" type="number" value="0">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label">Quantidade de seguranca</label>
                                                <input class="form-control" name="estoque_seguranca" type="number"
                                                    value="0">
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
