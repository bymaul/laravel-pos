<?php

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

uses(\Illuminate\Foundation\Testing\WithoutMiddleware::class);

test('report page can be rendered with data', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $this->get('/report')->assertStatus(200);
});
