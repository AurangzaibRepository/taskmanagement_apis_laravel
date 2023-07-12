<?php

namespace App\Listeners;

use App\Events\DepartmentDeleted;

class DeleteDepartmentUsers
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
    public function handle(DepartmentDeleted $event): void
    {
        $event->department->users()->each(function ($user) {
            $user->delete();
        });
    }
}
