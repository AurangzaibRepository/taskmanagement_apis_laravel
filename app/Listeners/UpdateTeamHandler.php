<?php

namespace App\Listeners;

use App\Events\TeamUpdated;
use Spatie\WebhookServer\WebhookCall;

class UpdateTeamHandler
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
    public function handle(TeamUpdated $event): void
    {
        WebhookCall::create()
            ->url(env('TEAM_WEBHOOK_URL'))
            ->payload(['user' => $event->user])
            ->useSecret(env('WEBHOOK_SECRET'))
            ->dispatch();
    }
}
