<?php

use App\Models\Category;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

uses(\Illuminate\Foundation\Testing\WithFaker::class);

test('category page can be rendered with data', function () {
    $user = User::factory()->create(
        [
            'role' => 'admin',
        ]
    );

    $response = $this
        ->actingAs($user)
        ->get('/category');

    $response->assertStatus(200);
});

test('category page can create data', function () {
    Category::create(['name' => 'CategoryTest']);

    $this->assertDatabaseHas('categories', ['name' => 'CategoryTest']);
});

test('category page can update data', function () {
    Category::create(['name' => 'CategoryTest']);
    Category::all()->first()->update(['name' => 'UpdateCategoryTest']);

    $this->assertDatabaseHas('categories', ['name' => 'UpdateCategoryTest']);
});

test('category page can delete data', function () {
    Category::create(['name' => 'CategoryTest']);
    Category::all()->first()->delete();

    $this->assertDatabaseMissing('categories', ['name' => 'CategoryTest']);
});
