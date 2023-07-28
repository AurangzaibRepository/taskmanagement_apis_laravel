<?php

namespace App\Listeners;

use App\Events\DepartmentUpdated;
use Spatie\WebhookServer\WebhookCall;

class UpdateDepartmentHandler
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
    public function handle(DepartmentUpdated $event): void
    {
        $data = [
            'department' => $event->department,
        ];
        $data['department']['team'] = $event->department->team;

        WebhookCall::create()
            ->url(config('app.client_webhook_url'))
            ->payload($data)
            ->useSecret(config('app.webhook_secret'))
            ->dispatch();
    }
}
