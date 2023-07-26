<?php

namespace Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_auth_login(): void
    {
        $payload = [
            'email' => 'user38@laravel.com',
            'password' => '12345678',
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
}
