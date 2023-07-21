<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
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

    public function test_task_listing(): void
    {
        $payload = [
            'page_number' => 1,
            'project_id' => Project::first()->id,
            'category_id' => Category::first()->id,
            'user_id' => User::first()->id,
            'status' => 'Open',
        ];

        $response = $this->postJson('/api/tasks/listing', $payload);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('status', true)
                ->hasAll(['data.page_number', 'data.records_count', 'data.records'])
            );
    }

    public function test_task_details(): void
    {
        $taskId = Task::first()->id;
        $response = $this->getJson("/api/tasks/{$taskId}");

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('status', true)
                ->hasAll([
                    'data.id',
                    'data.title',
                    'data.description',
                    'data.status',
                    'data.project_id',
                    'data.category_id',
                    'data.user_id',
                ])
                ->etc()
            );
    }
}
