<?php

namespace App\Listeners;

use App\Events\CategoryCreated;
use Spatie\WebhookServer\WebhookCall;

class CreateCategoryHandler
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
    public function handle(CategoryCreated $event): void
    {
        WebhookCall::create()
            ->url(config('app.client_webhook_url'))
            ->payload(['category' => $event->category])
            ->useSecret(config('app.webhook_secret'))
            ->dispatch();
    }
}
