<?php

namespace App\Listeners;

use App\Events\CategoryUpdated;
use Spatie\WebhookServer\WebhookCall;

class UpdateCategoryHandler
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
    public function handle(CategoryUpdated $event): void
    {
        WebhookCall::create()
            ->url(config('app.client_webhook_url'))
            ->payload(['category' => $event->category])
            ->useSecret(config('app.webhook_secret'))
            ->dispatch();
    }
}
