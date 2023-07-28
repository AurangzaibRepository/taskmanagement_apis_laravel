<?php

namespace App\Listeners;

use App\Events\ProjectUpdated;
use Spatie\WebhookServer\WebhookCall;

class UpdateProjectHandler
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
    public function handle(ProjectUpdated $event): void
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
