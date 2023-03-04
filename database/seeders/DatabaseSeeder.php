<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('123'),
            'role' => 'admin',
        ]);

        \App\Models\Category::create([
            'name' => 'Ice Coffee',
        ]);

        $createMultipleProducts = [
            [
                'category_id' => 1,
                'code' => 'PRD-000001',
                'name' => 'Caramel Coffee',
                'price' => 15000,
            ],
            [
                'category_id' => 1,
                'code' => 'PRD-000002',
                'name' => 'Vanilla Coffee',
                'price' => 15000,
            ],
            [
                'category_id' => 1,
                'code' => 'PRD-000003',
                'name' => 'Pandan Coffee',
                'price' => 15000,
            ],
            [
                'category_id' => 1,
                'code' => 'PRD-000004',
                'name' => 'Matcha Coffee',
                'price' => 15000,
            ],
            [
                'category_id' => 1,
                'code' => 'PRD-000005',
                'name' => 'Aren Coffee',
                'price' => 15000,
            ],
            [
                'category_id' => 1,
                'code' => 'PRD-000006',
                'name' => 'Moccachino Coffee',
                'price' => 15000,
            ],
            [
                'category_id' => 1,
                'code' => 'PRD-000007',
                'name' => 'Black Coffee',
                'price' => 10000,
            ]
        ];

        \App\Models\Product::insert($createMultipleProducts);
    }
}
