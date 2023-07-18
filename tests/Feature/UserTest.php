<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Team;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_user_all(): void
    {
        $teamId = Team::first()->id;
        $departmentId = Department::first()->id;
        $response = $this->getJson("/api/users/all/{$teamId}/{$departmentId}");

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('status', true)
                ->has('data')
            );
    }

    public function test_user_listing(): void
    {
        $user = User::first();
        $response = $this->postJson('/api/users/listing', [
            'page_number' => 1,
            'name' => $user->first_name,
            'team_id' => Team::first()->id,
            'department_id' => Department::first()->id,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->hasAll(['status', 'data'])
            );
    }
}
