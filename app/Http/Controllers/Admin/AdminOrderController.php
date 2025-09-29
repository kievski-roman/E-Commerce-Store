<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:viewAny,'.Order::class)->only('index');
        $this->middleware('can:create,'.Order::class)->only('create,store');

        $this->middleware('can:view,order')->only('show');
        $this->middleware('can:update,order')->only('edit', 'update');
        $this->middleware('can:delete,order')->only('destroy');
    }

    public function index()
    {
        $orders = Order::query()
            ->with(['address', 'items.product'])
            ->paginate(10);
        return view('admin.order.index', compact('orders'));
    }
    public function show(Order $order)
    {
        $order->loadMissing(['address', 'items.product']);
        return view('admin.order.show', compact('order'));
    }

    public function edit(Order $order)
    {

        return view('admin.order.edit', compact('order'));
    }

    public function update(OrderRequest $request, Order $order)
    {
        $data = $request->validated();
        $order->update($data);
        return redirect()->route('admin.order.index');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.order.index');
    }

}
