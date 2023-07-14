<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function category_page_can_be_rendered_with_data(): void
    {
        $user = User::factory()->create(
            [
                'role' => 'admin',
            ]
        );

        $response = $this
            ->actingAs($user)
            ->get('/category');

        $response->assertStatus(200);
    }

    /** @test */
    public function category_page_can_create_data(): void
    {
        Category::create(['name' => 'CategoryTest']);

        $this->assertDatabaseHas('categories', ['name' => 'CategoryTest']);
    }

    /** @test */
    public function category_page_can_update_data(): void
    {
        Category::create(['name' => 'CategoryTest']);
        Category::all()->first()->update(['name' => 'UpdateCategoryTest']);

        $this->assertDatabaseHas('categories', ['name' => 'UpdateCategoryTest']);
    }

    /** @test */
    public function category_page_can_delete_data(): void
    {
        Category::create(['name' => 'CategoryTest']);
        Category::all()->first()->delete();

        $this->assertDatabaseMissing('categories', ['name' => 'CategoryTest']);
    }
}
