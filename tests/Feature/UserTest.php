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
        $payload = [
            'page_number' => 1,
            'name' => $user->first_name,
            'team_id' => Team::first()->id,
            'department_id' => Department::first()->id,
        ];

        $response = $this->postJson('/api/users/listing', $payload);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->hasAll(['status', 'data'])
            );
    }

    public function test_user_details(): void
    {
        $userId = User::first()->id;
        $response = $this->getJson("/api/users/{$userId}");

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->hasAll(['status', 'data']));
    }

    public function test_user_add(): void
    {
        $latestUserId = User::latest('id')->first()->id;
        $latestUserId++;

        $payload = [
            'first_name' => 'test',
            'last_name' => "user{$latestUserId}",
            'email' => "test_user{$latestUserId}@laravel.com",
            'phone_number' => '123456',
            'team_id' => Team::first()->id,
            'department_id' => Department::first()->id,
            'role' => 'User',
            'password' => bcrypt('123456'),
        ];

        $response = $this->postJson('/api/users', $payload);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->hasAll(['status', 'data', 'message'])
            );
    }
}
