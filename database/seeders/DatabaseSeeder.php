<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $electronics = Category::factory()->root()->create(['name' => 'Electronics']);
        $sport       = Category::factory()->root()->create(['name' => 'Sport']);

        //  Electronics
        $phones  = Category::factory()->childOf($electronics)->create(['name' => 'Phones']);
        $laptops = Category::factory()->childOf($electronics)->create(['name' => 'Laptops']);

        Category::factory()->childOf($phones)->create(['name' => 'Android']);
        Category::factory()->childOf($phones)->create(['name' => 'iOS']);

        Category::factory()->childOf($laptops)->create(['name' => 'Ultrabooks']);
        Category::factory()->childOf($laptops)->create(['name' => 'Gaming']);

        //  Sport
        $gym      = Category::factory()->childOf($sport)->create(['name' => 'Gym']);
        $football = Category::factory()->childOf($sport)->create(['name' => 'Football']);

        Category::factory()->childOf($gym)->create(['name' => 'Dumbbells']);

        $shoes = Category::factory()->childOf($football)->create(['name' => 'Shoes']);
        $ball  = Category::factory()->childOf($football)->create(['name' => 'Ball']);

        Category::factory()->childOf($shoes)->create(['name' => 'Football Boots']);
        Category::factory()->childOf($shoes)->create(['name' => 'Futsal Shoes']);

        Category::factory()->childOf($ball)->create(['name' => 'Soccer Balls']);
        Category::factory()->childOf($ball)->create(['name' => 'Mini Soccer Balls']);


        $leafCategoryIds = Category::doesntHave('children')->pluck('id');

        Product::factory()
            ->count(30)
            ->make()
            ->each(function ($p) use ($leafCategoryIds) {
                $p->category_id = $leafCategoryIds->random();
                $p->save();
            });
    }
}
