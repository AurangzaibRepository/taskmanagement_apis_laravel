<?php

namespace Tests\Feature;

use App\Models\Department;
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

    public function test_department_details(): void
    {
        $departmentId = Department::first()->id;
        $response = $this->getJson("/api/departments/{$departmentId}");

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('status', true)
                ->has('data')
            );
    }

    public function test_department_add(): void
    {
        $payload = [
            'name' => 'Department test',
            'description' => 'Department test description',
            'team_id' => Team::first()->id,
        ];

        $response = $this->postJson('/api/departments', $payload);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('status', true)
                ->hasAll(['data', 'message'])
            );
    }

    public function test_department_update(): void
    {
        $departmentId = Department::first()->id;
        $payload = [
            'name' => 'Department updated',
            'description' => 'Department description updated',
            'team_id' => Team::first()->id,
        ];

        $response = $this->putJson("/api/departments/{$departmentId}", $payload);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('status', true)
                ->has('message')
            );
    }

    public function test_department_delete(): void
    {
        $departmentId = Department::latest('id')->first()->id;
        $response = $this->deleteJson("/api/departments/{$departmentId}");

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('status', true)
                ->has('message')
            );
    }
}
