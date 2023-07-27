<?php

namespace App\Listeners;

use App\Events\ProjectDeleted;
use App\Events\TeamDeleted;
use Spatie\WebhookServer\WebhookCall;

class DeleteTeamProjects
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
    public function handle(TeamDeleted $event): void
    {
        $event->team->projects()->each(function ($project) {
            ProjectDeleted::dispatch($project);
            $project->delete();
        });

        $event->team->departments()->each(function ($department) {
            $department->delete();
        });

        WebhookCall::create()
            ->url(env('TEAM_WEBHOOK_URL'))
            ->payload(['team' => $event->team])
            ->useSecret(env('WEBHOOK_SECRET'))
            ->dispatch();
    }
}
