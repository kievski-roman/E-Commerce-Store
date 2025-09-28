<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with("error", 'You need to login first');
        }
        $orders = Order::query()
            ->where('user_id', auth()->id())
            ->with(['address', 'items.product'])
            ->paginate(8);

        return view('order.index', compact('orders'));

    }

    public function create()
    {

        return view('order.create');
    }

    public function store(Request $request)
    {

    }

    public function show(Order $order)
    {
        $address = Address::query()
        ->where('address');
        dd($address);
        return view('order.show', compact('order'));
    }

}
