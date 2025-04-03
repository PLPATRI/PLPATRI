<?php

namespace App\Http\Controllers\Pedidos;

use App\Http\Controllers\Controller;
use App\Models\Pedidos as PedidoModal;
use App\Models\PedidosItems;

use Illuminate\Http\Request;

class Pedidos extends Controller
{
    public function index()
    {
        return view("pedidos.pedidos");
    }

    public function editarPedido($id)
    {
        $pedido = PedidoModal::find($id);

        if (!$pedido) {
            toastr()->error("Pedido não encontrado");
            return redirect()->route("pedidos");
        }

        $items = $pedido->items();

        // Aplica os filtros
        if (request()->has('referencia_de') && !empty(request('referencia_de'))) {
            $items = $items->whereHas('produto', function ($query) {
                $query->where('referencia', '>=', request('referencia_de'));
            });
        }

        if (request()->has('referencia_ate') && !empty(request('referencia_ate'))) {
            $items = $items->whereHas('produto', function ($query) {
                $query->where('referencia', '<=', request('referencia_ate'));
            });
        }
        if (request()->has('modelo') && !empty(request('modelo'))) {
            $items = $items->where('modelo', 'like', '%' . request('modelo') . '%');
        }

        if (request()->has('fornecedor') && !empty(request('fornecedor'))) {
            $items = $items->whereHas('produto.fornecedor', function ($query) {
                $query->where('razao_social', 'like', '%' . request('fornecedor') . '%');
            });
        }

        $pedido->items = $items->get();

        return view("pedidos.editar-pedido", [
            "pedido" => $pedido,
        ]);
    }


    public function excluirPedido(Request $request)
    {
        $pedido = $request->id_pedido;

        $pedido = PedidoModal::find($pedido);

        if (!$pedido) {
            toastr()->error("Pedido não encontrado");
            return redirect()->route("pedidos");
        }

        $pedido->delete();

        return redirect()->route("pedidos.get")->with("success", "Pedido excluído com sucesso");
    }

    public function excluirItemPedido(Request $request)
    {
        $item = $request->id_item;
        $pedido = $request->id_pedido;

        $item = PedidosItems::find($item);

        $pedido = PedidoModal::find($pedido);

        if (!$item) {
            toastr()->error("Item não encontrado");
            return redirect()->route("pedidos");
        }

        if (!$pedido) {
            toastr()->error("Pedido não encontrado");
            return redirect()->route("pedidos");
        }

        $pedido->valor -= $item->valor_total;
        $pedido->save();

        $item->delete();

        return redirect()->route("editar.pedido.get", $pedido)->with("success", "Item excluído com sucesso");
    }

    public function atualizarStatus(Request $request)
    {
        $status = $request->status;

        $pedido = PedidoModal::find($request->id_pedido);

        if (!$pedido) {
            toastr()->error("Pedido não encontrado");
            return redirect()->route("pedidos");
        }

        $pedido->status = $status;
        $pedido->save();

        return redirect()->route("editar.pedido.get", $pedido->id)->with("success", "Status do pedido atualizado com sucesso");
    }

    public function atualizarFinanceiro(Request $request)
    {
        $financeiro = $request->financeiro;

        $pedido = PedidoModal::find($request->id_pedido);

        if (!$pedido) {
            toastr()->error("Pedido não encontrado");
            return redirect()->route("pedidos");
        }

        $pedido->financeiro = $financeiro;
        $pedido->save();

        return redirect()->route("editar.pedido.get", $pedido->id)->with("success", "Status do pedido atualizado com sucesso");
    }
    public function salvarDesconto($pedidoId)
    {
        $pedido = Pedidos::find($pedidoId);

        if (!$pedido || !is_numeric($this->desconto)) {
            session()->flash('error', 'Erro ao aplicar desconto.');
            return;
        }

        $pedido->descontos = floatval($this->desconto);
        $pedido->valor = $pedido->valor_original - $pedido->descontos;
        $pedido->save();

        session()->flash('success', 'Desconto aplicado com sucesso.');
        
        return redirect()->route('editar.pedido.get', $pedidoId);
    }

    public function validarPedido(Request $request)
    {
        $pedido = PedidoModal::find($request->id_pedido);

        if (!$pedido) {
             toastr()->error("Pedido não encontrado ao validar.");
             return redirect()->route("pedidos");
        }

        $houveAlteracao = false;

        foreach ($request->input('quantidade') as $itemId => $novaQuantidade) {
            $item = $pedido->items()->find($itemId);

            if ($item && is_numeric($novaQuantidade) && $novaQuantidade >= 0) {
                if ($item->quantidade != $novaQuantidade) {
                    $item->quantidade = $novaQuantidade;
                    $item->valor_total = $item->valor_unitario * $novaQuantidade;
                    $item->save();
                    $houveAlteracao = true;
                }
            } else {
                 Log::warning("Item ID {$itemId} não encontrado ou quantidade inválida ({$novaQuantidade}) para Pedido ID {$pedido->id} durante validação.");
            }
        }

        if ($houveAlteracao) {
            // Calcula o valor bruto SOMENTE para usar no cálculo do valor final
            $valorBrutoCalculado = PedidosItems::where('pedido_id', $pedido->id)->sum('valor_total');

            // Atualiza APENAS o valor final (assumindo que 'valor' é o campo final)
            // Verifica se a coluna de desconto é 'descontos' ou 'desconto'
            $descontoAplicar = $pedido->desconto ?? 0; // Ou $pedido->desconto ?? 0

            // ATENÇÃO: Verifique se 'descontos' guarda VALOR ou PERCENTUAL
            // Se for percentual, o cálculo é diferente!
            // Ex: $pedido->valor = $valorBrutoCalculado * (1 - ($pedido->desconto / 100));
            $pedido->valor = $valorBrutoCalculado - $descontoAplicar;

            // REMOVIDO: $pedido->valor_original = $valorBrutoCalculado;

            $pedido->save();
        }

        return redirect()->back()->with('success', 'Pedido validado e quantidades/valores atualizados com sucesso.');
    }

    public function atualizarQuantidade(Request $request, $itemId)
    {
        try {
            $quantidade = $request->quantidade;
            if (!is_numeric($quantidade) || $quantidade < 0) {
                 toastr()->error('Quantidade inválida.');
                 return redirect()->back();
            }

            $item = PedidosItems::find($itemId);

            if (!$item) {
                toastr()->error('Item não encontrado.');
                return redirect()->back();
            }

            $item->quantidade = $quantidade;
            $item->valor_total = $item->valor_unitario * $quantidade;
            $item->save();

            $pedido = $item->pedido;
            $valorBrutoCalculado = PedidosItems::where('pedido_id', $pedido->id)->sum('valor_total');

            // Atualiza APENAS o valor final
            $descontoAplicar = $pedido->desconto ?? 0;// Ou $pedido->desconto ?? 0
            // Verifique se é VALOR ou PERCENTUAL
            $pedido->valor = $valorBrutoCalculado - $descontoAplicar;

            // REMOVIDO: $pedido->valor_original = $valorBrutoCalculado;

            $pedido->save();

            toastr()->success('Quantidade e valores atualizados com sucesso.');
            return redirect()->route('editar.pedido.get', ['id' => $pedido->id]);

        } catch (\Exception $e) {
            Log::error('Erro ao atualizar quantidade: ' . $e->getMessage());
            toastr()->error('Erro ao atualizar quantidade.');
            return redirect()->back();
        }
    }

    public function salvarObservacao(Request $request, $pedidoId)
    {
        $request->validate([
            'observacao' => 'nullable|string',
        ]);

        $pedido = PedidoModal::find($pedidoId);

        if (!$pedido) {
             toastr()->error("Pedido não encontrado ao salvar observação.");
             return redirect()->back();
        }

        $pedido->observacoes = $request->input('observacao');
        $pedido->save();

        return redirect()->route('editar.pedido.get', $pedidoId)
                         ->with('success', 'Observação salva com sucesso.');
    }
    
}