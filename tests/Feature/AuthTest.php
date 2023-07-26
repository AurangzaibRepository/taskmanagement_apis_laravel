<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Team;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_auth_login(): void
    {
        $latestUserId = User::latest('id')->first()->id;
        $latestUserId++;

        User::create([
            'first_name' => 'test',
            'last_name' => "user{$latestUserId}",
            'email' => "test_user{$latestUserId}@laravel.com",
            'phone_number' => '123456',
            'password' => '123456',
            'team_id' => Team::first()->id,
            'department_id' => Department::first()->id,
            'role' => 'User',
        ]);

        $payload = [
            'email' => "test_user{$latestUserId}@laravel.com",
            'password' => '123456',
        ];

        $response = $this->postJson('/api/auth/login', $payload);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('status', true)
                ->hasAll([
                    'data.first_name',
                    'data.last_name',
                    'data.email',
                    'data.phone_number',
                    'data.team_id',
                    'data.department_id',
                ])
            );
    }

    public function test_auth_change_password(): void
    {
        $latestUser = User::latest('id')->first();
        $payload = [
            'email' => $latestUser->email,
            'password' => '123456',
            'new_password' => '12345678',
        ];

        $response = $this->postJson('/api/auth/change-password', $payload);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('status', true)
                ->has('message')
            );
    }
}
