<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ReportTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    /** @test */
    public function report_page_can_be_rendered_with_data(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->get('/report')->assertStatus(200);
    }
}
