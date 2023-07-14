<?php

namespace Tests\Feature;

use App\Models\Team;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    public function test_project_all(): void
    {
        $teamId = Team::first()->id;
        $response = $this->getJson("/api/projects/all/{$teamId}");

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('status', true)
                ->has('data')
            );
    }

    public function test_project_listing(): void
    {
        $response = $this->postJson('/api/projects/listing', [
            'pageNumber' => 1,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('status', true)
                ->has('data')
            );
    }
}
