<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    //
    public function store(string $uuid, Request $request, CartService $service)
    {
        $data = $request->validate([
            'quantity' => 'required|integer|min:1',
            'product_id' => 'required|integer|exists:products,id'
        ]);
        $cart = $service->ensure($uuid, $request->user());
        $cart = $service->addItem($cart, $data['product_id'], $data['quantity']);
        return (new CartResource($cart))
            ->response()->setStatusCode(201);
    }
    public function update(string $uuid, Request $request, CartService $service)
    {
        $data = $request->validate([
            'quantity' => 'required|integer|min:1',
            'product_id' => 'required|integer|exists:products,id'
        ]);
        $cart = $service->ensure($uuid, $request->user());
        $cart = $service->updateItem($cart, $data['product_id'], $data['quantity']);
        return (new CartResource($cart))
            ->response()->setStatusCode(201);
    }
    public function destroy(string $uuid,int $productId, Request $request, CartService $service)
    {
        $cart = $service->ensure($uuid, $request->user());
        $cart = $service->deleteItem($cart,$productId );
        return (new CartResource($cart))->response()->setStatusCode(204);
    }
}
