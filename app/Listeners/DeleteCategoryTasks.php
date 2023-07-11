<?php

namespace App\Listeners;

use App\Events\CategoryDeleted;

class DeleteCategoryTasks
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
    public function handle(CategoryDeleted $event): void
    {
        $event->category->tasks()->each(function ($task) {
            $task->delete();
        });
    }
}
