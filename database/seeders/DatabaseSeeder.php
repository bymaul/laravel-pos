<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed the users
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Seed the categories
        $categories = ['Ice Coffee', 'Hot Coffee', 'Non Coffee', 'Snack'];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }

        // Seed the products
        $products = [
            // Ice Coffee
            ['category_id' => 1, 'code' => 'PRD-000001', 'name' => 'Caramel Coffee', 'price' => 15000],
            ['category_id' => 1, 'code' => 'PRD-000002', 'name' => 'Vanilla Coffee', 'price' => 15000],
            ['category_id' => 1, 'code' => 'PRD-000003', 'name' => 'Aren Coffee', 'price' => 15000],
            ['category_id' => 1, 'code' => 'PRD-000004', 'name' => 'Black Coffee', 'price' => 10000],
            // Hot Coffee
            ['category_id' => 2, 'code' => 'PRD-000005', 'name' => 'V60', 'price' => 15000],
            ['category_id' => 2, 'code' => 'PRD-000006', 'name' => 'Vietnam Drip', 'price' => 12000],
            ['category_id' => 2, 'code' => 'PRD-000007', 'name' => 'Coffelatte', 'price' => 14000],
            ['category_id' => 2, 'code' => 'PRD-000008', 'name' => 'Moccachino', 'price' => 15000],
            // Non Coffee
            ['category_id' => 3, 'code' => 'PRD-000009', 'name' => 'Bubble Gum Original', 'price' => 10000],
            ['category_id' => 3, 'code' => 'PRD-000010', 'name' => 'Chocolate Original', 'price' => 10000],
            ['category_id' => 3, 'code' => 'PRD-000011', 'name' => 'Matcha Original', 'price' => 10000],
            ['category_id' => 3, 'code' => 'PRD-000012', 'name' => 'Red Velvet Original', 'price' => 10000],
            // Snack
            ['category_id' => 4, 'code' => 'PRD-000013', 'name' => 'French Fries', 'price' => 9000],
            ['category_id' => 4, 'code' => 'PRD-000014', 'name' => 'Nugget', 'price' => 9000],
            ['category_id' => 4, 'code' => 'PRD-000015', 'name' => 'Sosis', 'price' => 9000],
            ['category_id' => 4, 'code' => 'PRD-000016', 'name' => 'Mix Platter', 'price' => 15000],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}
