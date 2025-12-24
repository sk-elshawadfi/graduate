<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $categories = Category::factory(5)->create();
        }

        Product::factory(50)
            ->make()
            ->each(function (Product $product) use ($categories) {
                $product->category_id = $categories->random()->id;
                $product->save();
            });
    }
}
