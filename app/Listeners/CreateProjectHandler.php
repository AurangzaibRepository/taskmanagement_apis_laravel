<?php

namespace App\Listeners;

use App\Events\ProjectCreated;
use Spatie\WebhookServer\WebhookCall;

class CreateProjectHandler
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
    public function handle(ProjectCreated $event): void
    {
        $data = [
            'project' => $event->project,
        ];
        $data['project']['team'] = $event->project->team;

        WebhookCall::create()
            ->url(config('app.client_webhook_url'))
            ->payload($data)
            ->useSecret(config('app.webhook_secret'))
            ->dispatch();
    }
}
