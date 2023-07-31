<?php

namespace App\Listeners;

use App\Events\UserCreated;
use Spatie\WebhookServer\WebhookCall;

class CreateUserHandler
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
    public function handle(UserCreated $event): void
    {
        $data = [
            'user' => $event->user,
        ];
        $data['user']['team'] = $event->user->team;
        $data['user']['deaprtment'] = $event->user->department;
        $data['user']['tasks'] = $event->user->tasks;

        WebhookCall::create()
            ->url(config('app.client_webhook_url'))
            ->payload($data)
            ->useSecret(config('app.webhook_secret'))
            ->dispatch();
    }
}
