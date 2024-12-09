<?php

namespace App\Http\Controllers;

use App\Models\Pedidos as ModelsPedidos;
use App\Models\PedidosItems;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

use App\Models\Etiquetas as Etiqueta;
use App\Models\Clientes;
use App\Models\Configuracoes;

class Etiquetas extends Controller
{
    public function index()
    {
        $numeroPaginate = Configuracoes::first();
        if (empty($numeroPaginate)) {
            $paginas = 10;
        } else {
            $paginas = $numeroPaginate->numero_itens_tabelas;
        }

        $clientes = Clientes::all();

        $etiquetas = Etiqueta::paginate($paginas);

        return view('etiquetas', [
            'clientes' => $clientes,
            'etiquetas' => $etiquetas
        ]);
    }

    public function post(Request $request)
    {
        $etiqueta = new Etiqueta;

        $etiqueta->cliente_id = $request->cliente_id;
        $etiqueta->razao_social = $request->cliente_selecionado;
        $etiqueta->cep = $request->cep;
        $etiqueta->cidade = $request->cidade;
        $etiqueta->rua = $request->rua;
        $etiqueta->numero = $request->numero;
        $etiqueta->bairro = $request->bairro;
        $result = $etiqueta->save();

        if ($result) {
            toastr('Etiqueta salva com sucesso', 'success');
            return redirect()->back();
        }
        toastr('Houve um erro ao salvar a etiqueta', 'error');
        return redirect()->back();
    }

    public function gerarPdf(Request $request)
    {

        $data = [
            'nome' => $request->razao_social,
            'rua' => str_replace('Rua', '', $request->rua),
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'uf' => $request->uf,
            'cep' => $request->cep,
            'numero' => $request->numero
        ];
        $pdf = PDF::loadView('pdf.modeloA4', $data)->setPaper('a4', 'portrait');

        return $pdf->download($request->razao_social . '.pdf');
    }

    public function delete(Request $request)
    {
        $etiqueta = Etiqueta::where('id', $request->id)->delete();
        if ($etiqueta) {
            toastr('Etiqueta Deletada Com Sucesso', 'success');
            return redirect()->back();
        }
        toastr('Houve um erro ao deletar a etiqueta.', 'error');
        return redirect()->back();
    }

    public function geraPdfPedido(Request $request)
    {
        $pedido = ModelsPedidos::findOrFail($request->id_pedido);

        $pedidoItems = PedidosItems::where('pedido_id', $pedido->id)->get();
        $cliente = Clientes::findOrFail($pedido->cliente_id);

        // Calculo do valor do desconto
        $valorDescontado = $pedido->valor * ($pedido->desconto / 100);
        $valorComDesconto = $pedido->valor - $valorDescontado;
        $data = [
            'pedido' => $pedido,
            'pedidoItems' => $pedidoItems,
            'cliente' => $cliente,
            'valorComDesconto' => $valorComDesconto, // Adiciona o valor do desconto nos dados
        ];

        $pdf = PDF::loadView('pdf.pedidoA4', $data)
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true);

        return $pdf->download('pedido_' . $request->id_pedido . '.pdf');
    }
}
