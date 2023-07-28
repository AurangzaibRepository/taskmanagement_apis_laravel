<?php

namespace App\Providers;

use App\Events\CategoryCreated;
use App\Events\CategoryDeleted;
use App\Events\CategoryUpdated;
use App\Events\DepartmentDeleted;
use App\Events\ProjectDeleted;
use App\Events\TeamCreated;
use App\Events\TeamDeleted;
use App\Events\TeamUpdated;
use App\Events\UserDeleted;
use App\Listeners\CreateTeamHandler;
use App\Listeners\DeleteCategoryTasks;
use App\Listeners\DeleteDepartmentUsers;
use App\Listeners\DeleteProjectTasks;
use App\Listeners\DeleteTeamProjects;
use App\Listeners\DeleteUserTasks;
use App\Listeners\UpdateTeamHandler;
use App\Listeners\CreateCategoryHandler;
use App\Listeners\UpdateCategoryHandler;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ProjectDeleted::class => [
            DeleteProjectTasks::class,
        ],
        TeamDeleted::class => [
            DeleteTeamProjects::class,
        ],
        CategoryDeleted::class => [
            DeleteCategoryTasks::class,
        ],
        DepartmentDeleted::class => [
            DeleteDepartmentUsers::class,
        ],
        UserDeleted::class => [
            DeleteUserTasks::class,
        ],
        TeamCreated::class => [
            CreateTeamHandler::class,
        ],
        TeamUpdated::class => [
            UpdateTeamHandler::class,
        ],
        CategoryCreated::class => [
            CreateCategoryHandler::class,
        ],
        CategoryUpdated::class => [
            UpdateCategoryHandler::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
