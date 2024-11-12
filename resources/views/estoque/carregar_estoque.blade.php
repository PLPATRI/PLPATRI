@section('title', 'Carregar Estoque - Combrim')


@extends('components.main')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Main content -->
            <section class="">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="box">
                            <livewire:estoque.carregar-estoque />
                        </div>
                        <!-- /.box -->
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
    </div>
    <!-- /.modal view -->
@endsection
