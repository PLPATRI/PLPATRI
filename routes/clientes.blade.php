@extends('components.main')

@section('title', 'Relatório de Compradores - Combrim')

@section('content')
<div class="container">
    <h1 class="mt-3">Relatório de Compradores - Ano {{ $anoSelecionado }}</h1>

    {{-- Formulário para Seleção de Ano --}}
    <div class="mb-3">
        <form action="{{ route('relatorio.clientes.get') }}" method="GET" class="form-inline">
            <label for="ano" class="mr-2">Selecionar Ano:</label>
            <select name="ano" id="ano" class="form-control mr-2" onchange="this.form.submit()">
                @foreach($anosDisponiveis as $ano)
                    <option value="{{ $ano }}" {{ $ano == $anoSelecionado ? 'selected' : '' }}>
                        {{ $ano }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    {{-- Tabela de Compradores --}}
    <h2>Compradores que Mais Gastaram em {{ $anoSelecionado }}</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Razão Social</th>
                <th>CPF/CNPJ</th>
                <th>Telefone</th>
                <th>Total de Compras</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clientes as $comprador)
                <tr>
                    <td>{{ $clientes->razao_social }}</td>
                    <td>{{ $clientes->cpf_cnpj }}</td>
                    <td>{{ $clientes->telefone }}</td>
                    <td>R$ {{ number_format($comprador->total_compras, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
