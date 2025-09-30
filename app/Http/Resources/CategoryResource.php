<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'parent_id' => $this->parent_id,
            'depth' => $this->depth,
            // ancestors = масив усіх предків
            'ancestors'  => $this->when($this->parent_id, function () {
                $path = [];
                $node = $this->parent; // стартуємо з безпосереднього батька
                // поки є батьки піднімаємося вгору по дереву
                while ($node) {
                    $path[] = ['id' => $node->id, 'name' => $node->name];
                    $node = $node->parent;// наступний рівень угору
                }
                return array_reverse($path);
            }),
        ];
    }
}
