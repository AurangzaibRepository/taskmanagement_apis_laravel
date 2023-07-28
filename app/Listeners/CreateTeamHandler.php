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
            ->url(config('app.client_webhook_url'))
            ->payload(['team' => $event->team])
            ->useSecret(config('app.webhook_secret'))
            ->dispatch();
    }
}
