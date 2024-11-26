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

        if (request()->has('referencia') && !empty(request('referencia'))) {
            $items = $items->whereHas('produto', function ($query) {
                $query->where('referencia', 'like', '%' . request('referencia') . '%');
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
}
