<?php

namespace App\Listeners;

use App\Events\ProjectDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DeleteProjectTasks
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ProjectDeleted $event): void
    {
        $event->project->tasks()->each(function ($task) {
            $task->delete();
        });
    }
}
