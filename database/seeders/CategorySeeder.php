<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Project;
use App\Models\Task;
use App\Models\Team;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $project = Project::factory()
            ->for(Team::factory()->create())
            ->create();

        $task = Task::factory()
            ->for($project)
            ->count(2);

        Category::factory()
            ->has($task)
            ->create();
    }
}
