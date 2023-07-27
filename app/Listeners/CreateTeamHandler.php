<?php

namespace App\Listeners;

use App\Events\TeamCreated;

class CreateTeamHandler
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
    public function handle(TeamCreated $event): void
    {
    }
}
