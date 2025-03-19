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

    public function validarPedido(Request $request)
    {
        $pedido = PedidoModal::find($request->id_pedido);

        foreach ($request->input('quantidade') as $itemId => $novaQuantidade) {
            $item = $pedido->items->find($itemId);
            if ($item) {
                $item->quantidade = $novaQuantidade;
                $item->save();
            }
        }

        return redirect()->back()->with('success', 'Pedido validado e quantidades atualizadas com sucesso.');
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
    public function salvarObservacao($pedidoId)
    {


        $pedido = PedidoModal::find($pedidoId);

        if (isset($this->observacao[$pedidoId]) && !empty($this->observacao[$pedidoId])) {
            $pedido->observacoes = $this->observacao[$pedidoId];
            $pedido->save();
            session()->flash('success', 'Observação salva com sucesso.');
        } else {
            session()->flash('error', 'Confirme sua anotação.');
        }

        $this->pedidoSelecionado = $pedido;
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

    public function atualizarQuantidade(Request $request, $itemId)
    {
        try {
            $quantidade = $request->quantidade;
            $item = PedidosItems::find($itemId);
            
            if (!$item || !is_numeric($quantidade) || $quantidade < 1) {
                toastr()->error('Quantidade inválida');
                return redirect()->back();
            }

            // Store old value for difference calculation
            $valorAnterior = $item->valor_total;
            
            // Update item quantity and total value
            $item->quantidade = $quantidade;
            $item->valor_total = $item->valor_unitario * $quantidade;
            $item->save();

            // Update order total value
            $pedido = $item->pedido;
            $pedido->valor_total = PedidosItems::where('pedido_id', $pedido->id)->sum('valor_total');
            $pedido->valor_original = $pedido->valor_total;
            $pedido->save();

            toastr()->success('Quantidade e valores atualizados com sucesso');
            return redirect()->route('editar.pedido.get', $pedido->id);
            
        } catch (\Exception $e) {
            \Log::error('Erro ao atualizar quantidade: ' . $e->getMessage());
            toastr()->error('Erro ao atualizar quantidade');
            return redirect()->back();
        }
    }
    
}