<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class TaskTest extends TestCase
{
    public function test_task_all(): void
    {
        $projectId = Project::first()->id;
        $response = $this->getJson("/api/tasks/all/{$projectId}");

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('status', true)
                ->has('data')
            );
    }
}
