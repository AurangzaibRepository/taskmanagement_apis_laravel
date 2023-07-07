<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $team = Team::factory()->create();
        $department = Department::factory()
            ->for($team)
            ->create();

        User::factory()
            ->count(2)
            ->for($team)
            ->for($department)
            ->create();
    }
}
