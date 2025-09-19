<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //
    public function index()
    {
        // Получаем корзину из сессии, по умолчанию пустой массив
        $cart = session()->get('cart', []);
        // Загружаем продукты по их ID
        $products = Product::whereIn('id', array_keys($cart))->get();
        // Считаем общую сумму
        $total = array_sum(array_map(fn($item) => $item['quantity'] * $item['price'], $cart));

        return view('cart.index', compact('cart', 'products', 'total'));
    }
    public function add(Product $product , Request $request)
    {
        $quantity = max(1, $request->get('quantity',1));
        $cart = session()->get('cart', []);
        if(isset($cart[$product->id])){
            $cart[$product->id]['quantity'] += $quantity;
        }else{
            $cart[$product->id] = [
                'quantity' => $quantity,
                'price' => $product->price,
            ];
        }
        session()->put('cart', $cart);
        $totalItems = array_sum(array_map(fn($item) => $item['quantity'], $cart));

        return redirect()->route('product.index')->with('success', 'Product added to cart')->with('totalItems', $totalItems);
    }
    public function remove(Product $product )
    {
        $cart = session()->get('cart', []);
        unset($cart[$product->id]);
        session()->put('cart', $cart);
        return redirect()->route('cart.index');
    }
    public function clear()
    {
        session()->forget('cart');
        session()->forget('totalItems');
        return redirect()->route('cart.index');
    }
}
