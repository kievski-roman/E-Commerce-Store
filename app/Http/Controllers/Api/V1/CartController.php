<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //
    public function create(Request $request, CartService $service)
    {
        $cart = $service->createFor($request->user());
        return (new CartResource($cart->load('items.product')))->response()->setStatusCode(201);
    }
    public function show(string $uuid, Request $request, CartService $service)
    {
        $cart = $service->ensure($uuid, $request->user());

        return new CartResource($cart->load('items.product'));
    }
    public function store (string $uuid,Request $request, CartService $service)
    {
        $data = $request->validate([
            'quantity' => 'required|integer|min:1',
            'product_id' => 'required|integer|exists:products,id'
        ]);
        $cart = $service->ensure($uuid, $request->user());
        $cart = $service->addItem($cart, $data['product_id'], $data['quantity']);
        return (new CartResource($cart))
            ->response()->setStatusCode(201);    }
}
