<?php

namespace App\Listeners;

use App\Events\UserDeleted;

class DeleteUserTasks
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
    public function handle(UserDeleted $event): void
    {
        $event->user->tasks()->each(function ($task) {
            $task->delete();
        });
    }
}
