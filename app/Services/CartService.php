<?php

namespace App\Services;

use App\Models\{Cart, CartItem, Product, User};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CartService
{
    public function ensure(?string $uuid = null, ?User $user = null): Cart
    {
        if ($uuid) {
            $cart = Cart::with(['items.product'])->where('uuid', $uuid)->first();
            if ($cart) {
                if ($user && !$cart->user_id) {
                    $cart->user()->associate($user)->save();
                }
                return $cart;
            }
        }
        return $this->createFor($user);
    }

    public function createFor(?User $user = null): Cart
    {
        $cart = Cart::create([
            "uuid" => (string)Str::uuid(),
            "user_id" => $user?->id,
            'expires_at' => $user ? null : now()->addDays(14),
        ]);
        return $cart->fresh(['items.product']);
    }

    public function addItem(Cart $cart, int $productId, int $qty): Cart
    {

        return DB::transaction(function () use ($cart, $productId, $qty) {
            // get product id if we have
            $product = Product::findOrFail($productId);

            //price from product
            $price = $product->price;

            //get first product which get to id and put it in cart_items
            $item = $cart->items()->where('product_id', $productId)->first();
            if ($item) {
                $item->quantity = min($item->quantity + $qty, 100);
                $item->unit_price = $price;
                $item->save();
            } else {
                $cart->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'unit_price' => $price,
                    'product_name' => $product->name,
                ]);
            }
            return $cart->fresh(['items.product']);
        });
    }

    public function updateItem(Cart $cart, int $productId, int $qty): Cart
    {

        return DB::transaction(function () use ($cart, $productId, $qty) {
            $qty = max(1, min($qty, 100));
            $product = Product::lockForUpdate()->findOrFail($productId);

            $item = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $product->id)
                ->lockForUpdate()
                ->firstOrFail();

        if($qty > $product->quantity){
            abort(422, 'Product out of stock');
        }
        $item->quantity = $qty;
        $item->save();
        return $cart->fresh(['items.product']);
        });
    }
    public function deleteItem(Cart $cart, int $productId): Cart
    {
        $cart->items()->where('product_id', $productId)->delete();
        return $cart->fresh(['items.product']);
    }
    public function deleteAllItems(Cart $cart): Cart
    {
        $cart->items()->delete();
        return $cart->fresh(['items.product']);
    }

}
