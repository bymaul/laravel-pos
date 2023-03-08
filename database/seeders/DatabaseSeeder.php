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

        \App\Models\Product::create([
            'category_id' => 1,
            'code' => 'PRD-000001',
            'name' => 'Caramel Coffee',
            'price' => 15000,
        ]);
    }
}
