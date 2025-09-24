<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста');
        }

        $products = Product::whereIn('id', array_keys($cart))->get();
        $total = array_sum(array_map(fn($item) => $item['quantity'] * $item['price'], $cart));

        return view('checkout.index', compact('cart', 'products', 'total'));
    }

    public function store(OrderRequest $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста');
        }

        // Создаём адрес
        $address = Address::create([
            'user_id' => Auth::id() ?? null,
            'name' => $request->name,
            'address_line' => $request->address_line,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
            'is_default' => false,
        ]);

        // Подсчёт итоговой суммы (с налогом 10%)
        $subtotal = array_sum(array_map(fn($item) => $item['quantity'] * $item['price'], $cart));
        $total = $subtotal * 1.1; // +10% GST

        // Создаём заказ
        $order = Order::create([
            'user_id' => Auth::id() ?? null,
            'address_id' => $address->id,
            'status' => 'pending',
            'total_price' => $total,
            'payment_method' => $request->payment_method,
        ]);

        // Сохраняем товары
        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        // Очищаем корзину
        session()->forget('cart');
        session()->forget('totalItems');

        return redirect()->route('order.show', $order->id)->with('success', 'Заказ успешно создан!');
    }
}
