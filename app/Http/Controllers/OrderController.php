<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
      //  $this->middleware('auth');
    }

    public function index()
    {
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


    public function show(Order $order)
    {


        $order
            ->loadMissing(['address', 'items.product'])
            ->where('user_id', auth()->id());
        return view('order.show', compact('order'));
    }

}
