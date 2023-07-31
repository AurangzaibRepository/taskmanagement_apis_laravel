<?php

namespace App\Listeners;

use App\Events\UserUpdated;
use Spatie\WebhookServer\WebhookCall;

class UpdateUserListener
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
    public function handle(UserUpdated $event): void
    {
        $data = [
            'user' => $event->user,
        ];
        $data['user']['team'] = $event->user->team;
        $data['user']['department'] = $event->user->department;
        $data['user']['tasks'] = $event->user->tasks;

        WebhookCall::create()
            ->url(config('app.client_webhook_url'))
            ->payload($data)
            ->useSecret(config('app.webhook_secret'))
            ->dispatch();
    }
}
