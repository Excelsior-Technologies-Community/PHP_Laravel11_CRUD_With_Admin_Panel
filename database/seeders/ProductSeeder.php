<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $images = [
            '1764744904_5f06f0f5-82bd-4da7-ada6-642dfb5af22c.jpg',
            '1764745912_160a2a08-4b2f-4054-bcc1-898b07c3ca69.jpg',
            '1764746058_0ec9bba3-4bdf-445c-8b57-64bda8755bc1.jpg',
            '1764833579_6931392b7f121.jpg',
            '1764833579_6931392b7fc4f.jpg',
            '1764834119_69313b4761be1.jpg',
            '1764834119_69313b4762d1a.jpg',
            '1764834659_5f06f0f5-82bd-4da7-ada6-642dfb5af22c.jpg',
            '1764834697_5f06f0f5-82bd-4da7-ada6-642dfb5af22c.jpg',
            '1764834716_5f06f0f5-82bd-4da7-ada6-642dfb5af22c.jpg',
            '1764834853_5f06f0f5-82bd-4da7-ada6-642dfb5af22c.jpg',
            '1764907539_07f0679e-b37c-419c-8644-44f8fda107e2.jpg',
            '1764911621_69326a0568711_07f0679e-b37c-419c-8644-44f8fda107e2.jpg',
            '1764912413_69326d1ddd1f9.jpg',
            '1764912413_69326d1ddd535.jpg',
            '1764912953_69326f39a795e.jpg',
            '1764912953_69326f39a7ca6.jpg',
            '1764916879_69327e8f154fa.jpg',
            '1764917249_69328001933fe.jpg',
            '1764917477_693280e58c0e3.jpg',
        ];

        $categories = ['Electronics', 'Clothing', 'Home & Garden', 'Sports', 'Books', 'Toys', 'Beauty', 'Automotive', 'Food', 'Health'];
        $sizes = ['Small', 'Medium', 'Large', 'XL', 'S', 'M', 'L', 'One Size'];
        $colors = ['Red', 'Blue', 'Green', 'Black', 'White', 'Yellow', 'Orange', 'Purple', 'Pink', 'Brown'];
        $names = [
            'Wireless Headphones', 'Smart Watch', 'Laptop Stand', 'Bluetooth Speaker', 'USB-C Hub',
            'Running Shoes', 'Casual T-Shirt', 'Denim Jacket', 'Sports Bag', 'Winter Hat',
            'Desk Lamp', 'Plant Pot', 'Wall Clock', 'Throw Pillow', 'Curtain Set',
            'Yoga Mat', 'Dumbbell Set', 'Resistance Bands', 'Jump Rope', 'Water Bottle'
        ];
        $details = [
            'High quality product with excellent features and durable build.',
            'Premium material with modern design and long-lasting performance.',
            'Compact and portable, perfect for everyday use.',
            'Innovative design with advanced technology for superior experience.',
            'Eco-friendly materials with sustainable manufacturing process.',
        ];

        Product::truncate();

        foreach (range(0, 19) as $i) {
            Product::create([
                'name' => $names[$i],
                'details' => $details[$i % count($details)],
                'price' => rand(100, 5000),
                'size' => $sizes[$i % count($sizes)],
                'color' => $colors[$i % count($colors)],
                'category' => $categories[$i % count($categories)],
                'image' => 'images/' . $images[$i],
            ]);
        }
    }
}