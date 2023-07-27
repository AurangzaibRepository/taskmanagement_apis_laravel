<?php

namespace App\Listeners;

use App\Events\TeamCreated;
use Spatie\WebhookServer\WebhookCall;

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
        WebhookCall::create()
            ->url(env('TEAM_WEBHOOK_URL'))
            ->payload(['user' => $event->team])
            ->useSecret(env('WEBHOOK_SECRET'))
            ->dispatch();
    }
}
