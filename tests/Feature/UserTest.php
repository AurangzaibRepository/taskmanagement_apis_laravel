<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
        Storage:fake('public');

        $payload = [
            'first_name' => 'test',
            'last_name' => "user{$latestUserId}",
            'email' => "test_user{$latestUserId}@laravel.com",
            'phone_number' => '123456',
            'team_id' => Team::first()->id,
            'department_id' => Department::first()->id,
            'role' => 'User',
            'password' => bcrypt('123456'),
            'image' => $file = UploadedFile::fake()->image("{$latestUserId}.jpg"),
        ];

        $response = $this->postJson('/api/users', $payload);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('status', true)
                ->hasAll(['data', 'message'])
            );

        Storage::disk('public')->assertExists("/images/users/{$latestUserId}.jpg");
    }

    public function test_user_update(): void
    {
        $user = User::latest('id')->first();
        Storage::fake('public');

        $payload = [
            'first_name' => "{$user->first_name}",
            'last_name' => "{$user->id}",
            'email' => "user{$user->id}@laravel.com",
            'phone_number' => '123456',
            'team_id' => Team::first()->id,
            'department_id' => Department::first()->id,
            'role' => 'User',
            'password' => bcrypt('123456'),
            'image' => $file = UploadedFile::fake()->image("{$user->id}.jpg"),
        ];

        $response = $this->putJson("/api/users/{$user->id}", $payload);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('status', true)
                ->has('message')
            );

        Storage::disk('public')->assertExists("/images/users/{$user->id}.jpg");
    }
}
