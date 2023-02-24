<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ProductTest extends TestCase
{

    use RefreshDatabase;
    use WithoutMiddleware;

    /** @test */
    public function product_page_can_be_rendered_with_data(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->get('/product')->assertStatus(200);
    }

    /** @test */
    public function product_page_can_create_data(): void
    {
        $categories = Category::create(['name' => 'CategoryTest']);
        $categories = Category::all()->first();
        $data = Product::create(['name' => 'ProductTest', 'category_id' => $categories->id, 'code' => 'ProductTest', 'price' => 1000])->make()->toArray();

        $this->assertDatabaseHas('products', $data);
    }

    /** @test */
    public function product_page_can_update_data(): void
    {
        $categories = Category::create(['name' => 'CategoryTest']);
        $categories = Category::all()->first();
        Product::create(['name' => 'ProductTest', 'category_id' => $categories->id, 'code' => 'ProductTest', 'price' => 1000]);
        Product::all()->first()->update(['name' => 'UpdateProductTest']);

        $this->assertDatabaseHas('products', ['name' => 'UpdateProductTest']);
    }

    /** @test */
    public function product_page_can_delete_data(): void
    {
        $categories = Category::create(['name' => 'CategoryTest']);
        $categories = Category::all()->first();
        Product::create(['name' => 'ProductTest', 'category_id' => $categories->id, 'code' => 'ProductTest', 'price' => 1000]);
        Product::all()->first()->delete();

        $this->assertDatabaseMissing('products', ['name' => 'ProductTest', 'category_id' => 1, 'code' => 'ProductTest', 'price' => 1000]);
    }
}
