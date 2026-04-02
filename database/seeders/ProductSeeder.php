<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create egg products for poultry management system
        Product::create([
            'product_name' => 'Small Eggs - Tray of 30',
            'egg_size' => 'small',
            'quantity_per_unit' => 30,
            'description' => 'Fresh small-sized eggs, perfect for baking and cooking. Each tray contains 30 eggs.',
            'price' => 10000.00,
            'stock' => 50,
            'discount' => 0,
            'image' => 'product/eggs-small.jpg'
        ]);

        Product::create([
            'product_name' => 'Medium Eggs - Tray of 30',
            'egg_size' => 'medium',
            'quantity_per_unit' => 30,
            'description' => 'Fresh medium-sized eggs, ideal for everyday use. Each tray contains 30 eggs.',
            'price' => 12000.00,
            'stock' => 100,
            'discount' => 0,
            'image' => 'product/eggs-medium.jpg'
        ]);

        Product::create([
            'product_name' => 'Large Eggs - Tray of 30',
            'egg_size' => 'large',
            'quantity_per_unit' => 30,
            'description' => 'Fresh large-sized eggs, great for all purposes. Each tray contains 30 eggs.',
            'price' => 14000.00,
            'stock' => 80,
            'discount' => 5,
            'image' => 'product/eggs-large.jpg'
        ]);

        Product::create([
            'product_name' => 'Extra Large Eggs - Tray of 30',
            'egg_size' => 'extra_large',
            'quantity_per_unit' => 30,
            'description' => 'Premium extra large eggs, perfect for special occasions. Each tray contains 30 eggs.',
            'price' => 16000.00,
            'stock' => 40,
            'discount' => 0,
            'image' => 'product/eggs-xlarge.jpg'
        ]);

        Product::create([
            'product_name' => 'Mixed Size Eggs - Half Tray (15)',
            'egg_size' => 'medium',
            'quantity_per_unit' => 15,
            'description' => 'Fresh mixed-size eggs in a convenient half tray. Perfect for small families.',
            'price' => 6000.00,
            'stock' => 60,
            'discount' => 0,
            'image' => 'product/eggs-mixed.jpg'
        ]);
    }
}
