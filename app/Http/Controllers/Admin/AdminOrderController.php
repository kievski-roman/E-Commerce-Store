<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    //
    public function index()
    {
        $this->authorize('viewAny', Order::class);

        $orders = Order::query()
            ->with(['address', 'items.product'])
            ->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function edit(Order $order)
    {
        $this->authorize('update', $order);
    }

    public function update(OrderRequest $request, Order $order)
    {
        $this->authorize('update', $order);
        $data = $request->validate();
        $order->update($data);
        return redirect()->route('admin.orders.index');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.order.index');
    }

}
