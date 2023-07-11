<?php

namespace App\Listeners;

use App\Events\CategoryDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
    }
}
