<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'name'     => $this->faker->unique()->words(2, true),
            'parent_id'=> null,
            'depth'    => 1,
            'position' => $this->faker->numberBetween(0, 10),
        ];
    }

    public function root(): static
    {
        return $this->state(fn () => ['parent_id' => null, 'depth' => 1]);
    }

    public function childOf(Category $parent): static
    {
        return $this->state(fn () => [
            'parent_id' => $parent->id,
            'depth'     => min(($parent->depth ?? 1) + 1, 6),
            'position'  => $this->faker->numberBetween(0, 10),
        ]);
    }
}
