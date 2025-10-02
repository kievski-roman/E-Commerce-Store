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
    public function clear(string $uuid ,Request $request, CartService $service)
    {
        $cart = $service->ensure($uuid, $request->user());
        $cart = $service->deleteAllItems($cart);
        return new CartResource($cart->load('items.product'));
    }

}
