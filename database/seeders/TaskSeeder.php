<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\Team;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $team = Team::factory()->create();
        $project = Project::factory()
            ->for($team)
            ->create();

        Task::factory()
            ->count(2)
            ->for($project)
            ->create();
    }
}
