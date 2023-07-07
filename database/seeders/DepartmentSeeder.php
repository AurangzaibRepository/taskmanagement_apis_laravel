<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $team = Team::factory()->create();
        $user = User::factory()
            ->for($team)
            ->count(2);

        Department::factory()
            ->for($team)
            ->has($user)
            ->create();
    }
}
