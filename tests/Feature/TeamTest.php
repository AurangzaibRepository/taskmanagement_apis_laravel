<?php

namespace Tests\Feature;

use App\Models\Team;
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

    public function test_team_details(): void
    {
        $teamId = Team::first()->id;
        $response = $this->getJson("/api/teams/{$teamId}");

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('status', true)
                ->has('data')
            );
    }

    public function test_team_add(): void
    {
        $recordCount = Team::count() + 1;
        $payload = [
            'code' => "T{$recordCount}",
            'name' => 'Team test',
            'description' => 'Team test description',
        ];
        $response = $this->postJson('/api/teams', $payload);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('status', true)
                ->hasAll(['data', 'message'])
            );
    }

    public function test_team_update(): void
    {
        $team = Team::first();
        $payload = [
            'code' => "T{$team->id} updated",
            'name' => "T{$team->id} updated",
            'description' => "T{$team->id} updated",
        ];

        $response = $this->putJson("/api/teams/{$team->id}", $payload);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('status', true)
                ->has('message')
            );
    }

    public function test_team_delete(): void
    {
        $teamId = Team::latest('id')->first()->id;
        $response = $this->deleteJson("/api/teams/{$teamId}");

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('status', true)
                ->has('message')
            );
    }
}
