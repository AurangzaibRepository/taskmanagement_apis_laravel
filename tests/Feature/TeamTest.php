<?php

namespace Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class TeamTest extends TestCase
{
    public function test_team_all(): void
    {
        $response = $this->getJson('/api/teams/all');

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('status', true)
                ->has('data')
            );
    }

    public function test_team_listing(): void
    {
        $response = $this->postJson('/api/teams/listing', [
            'page_number' => 1,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('status', true)
                ->has('data')
            );
    }
}
