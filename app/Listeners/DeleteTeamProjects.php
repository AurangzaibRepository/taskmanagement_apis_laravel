<?php

namespace App\Listeners;

use App\Events\TeamDeleted;

class DeleteTeamProjects
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(TeamDeleted $event): void
    {
        $event->team->projects()->each(function ($project) {
            $project->delete();
        });

        $event->team->departments()->each(function ($department) {
            $department->delete();
        });
    }
}
