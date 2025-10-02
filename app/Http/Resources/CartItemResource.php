<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "product_id" => $this->product_id,
            "name" => $this->product_name,
            "quantity" => $this->quantity,
            "price" => $this->unit_price_cents,
            "total" => $this->quantity * $this->unit_price,
        ];
    }
}
