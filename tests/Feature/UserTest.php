<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Team;
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
}
