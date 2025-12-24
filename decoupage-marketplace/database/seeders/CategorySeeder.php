<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Upcycled Furniture',
            'Decoupage Art',
            'Eco Decor',
            'Handcrafted Gifts',
            'Reclaimed Wood',
            'Vintage Revival',
            'Garden Creations',
            'Sustainable Fashion',
            'Kids Crafts',
            'Seasonal Specials',
        ];

        foreach ($categories as $index => $name) {
            Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'description' => 'Shop curated ' . strtolower($name) . ' made from recycled materials.',
                    'image_url' => "https://source.unsplash.com/random/800x600?sig={$index}&nature,craft",
                    'display_order' => $index + 1,
                    'is_featured' => $index < 4,
                ]
            );
        }
    }
}
