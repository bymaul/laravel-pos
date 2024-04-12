<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

uses(\Illuminate\Foundation\Testing\WithoutMiddleware::class);

test('product page can be rendered with data', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $this->get('/product')->assertStatus(200);
});

test('product page can create data', function () {
    $categories = Category::create(['name' => 'CategoryTest']);
    $categories = Category::all()->first();
    $data = Product::create(['name' => 'ProductTest', 'category_id' => $categories->id, 'code' => 'ProductTest', 'price' => 1000])->make()->toArray();

    $this->assertDatabaseHas('products', $data);
});

test('product page can update data', function () {
    $categories = Category::create(['name' => 'CategoryTest']);
    $categories = Category::all()->first();
    Product::create(['name' => 'ProductTest', 'category_id' => $categories->id, 'code' => 'ProductTest', 'price' => 1000]);
    Product::all()->first()->update(['name' => 'UpdateProductTest']);

    $this->assertDatabaseHas('products', ['name' => 'UpdateProductTest']);
});

test('product page can delete data', function () {
    $categories = Category::create(['name' => 'CategoryTest']);
    $categories = Category::all()->first();
    Product::create(['name' => 'ProductTest', 'category_id' => $categories->id, 'code' => 'ProductTest', 'price' => 1000]);
    Product::all()->first()->delete();

    $this->assertDatabaseMissing('products', ['name' => 'ProductTest', 'category_id' => 1, 'code' => 'ProductTest', 'price' => 1000]);
});
