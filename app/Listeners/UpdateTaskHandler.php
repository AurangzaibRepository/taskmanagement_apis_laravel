<?php

namespace App\Listeners;

use App\Events\TaskUpdated;
use Spatie\WebhookServer\WebhookCall;

class UpdateTaskHandler
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
    public function handle(TaskUpdated $event): void
    {
        $data = [
            'task' => $event->task,
        ];
        $data['task']['project'] = $event->task->project;
        $data['task']['category'] = $event->task->category;
        $data['task']['user'] = $event->task->user;

        WebhookCall::create()
            ->url(config('app.client_webhook_url'))
            ->payload($data)
            ->useSecret(config('app.webhook_secret'))
            ->dispatch();
    }
}
