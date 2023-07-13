<?php

namespace Tests\Feature;

use App\Models\Team;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class DepartmentTest extends TestCase
{
    public function test_department_all(): void
    {
        $teamId = Team::first()->id;
        $response = $this->getJson("/api/departments/all/{$teamId}");

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('status', true)
                ->has('data')
            );
    }

    public function test_department_listing(): void
    {
        $response = $this->postJson('/api/departments/listing', [
            'page_number' => 1,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('status', true)
                ->has('data')
            );
    }
}
