<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 test products
        \App\Models\Product::factory(10)->create([
            'name' => 'Test Product',
            'label' => 'Test Label',
            'photo' => 'storage/test.jpg',
            'price' => 9.99,
            'stock' => 100,
        ]);
    }
}
