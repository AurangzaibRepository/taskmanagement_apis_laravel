<?php

namespace Tests\Feature;

use App\Models\Project;
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

    public function test_project_details(): void
    {
        $projectId = Project::first()->id;
        $response = $this->getJson("/api/projects/{$projectId}");

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('status', true)
                ->has('data')
            );
    }

    public function test_project_add(): void
    {
        $latestId = Project::latest('id')->first()->id + 1;
        $payload = [
            'code' => "P{$latestId}",
            'name' => "Project{$latestId}",
            'description' => "Project {$latestId} description",
            'team_id' => Team::first()->id,
        ];

        $response = $this->postJson('/api/projects', $payload);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('status', true)
                ->hasAll(['data', 'message'])
            );
    }

    public function test_project_update(): void
    {
        $project = Project::first();
        $payload = [
            'code' => "P{$project->id} updated",
            'name' => "P{$project->id} updated",
            'description' => "P{$project->id} description updated",
            'team_id' => Team::first()->id,
        ];

        $response = $this->putJson("/api/projects/{$project->id}", $payload);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('status', true)
                ->has('message')
            );
    }

    public function test_project_delete(): void
    {
        $projectId = Project::latest('id')->first()->id;
        $response = $this->deleteJson("/api/projects/{$projectId}");

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('status', true)
                ->has('message')
            );
    }
}
