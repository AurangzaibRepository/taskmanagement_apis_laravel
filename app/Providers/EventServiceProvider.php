<?php

namespace App\Providers;

use App\Events\CategoryCreated;
use App\Events\CategoryDeleted;
use App\Events\CategoryUpdated;
use App\Events\DepartmentCreated;
use App\Events\DepartmentDeleted;
use App\Events\DepartmentUpdated;
use App\Events\ProjectCreated;
use App\Events\ProjectDeleted;
use App\Events\ProjectUpdated;
use App\Events\TaskCreated;
use App\Events\TaskUpdated;
use App\Events\TeamCreated;
use App\Events\TeamDeleted;
use App\Events\TeamUpdated;
use App\Events\UserDeleted;
use App\Listeners\CreateCategoryHandler;
use App\Listeners\CreateDepartmentHandler;
use App\Listeners\CreateProjectHandler;
use App\Listeners\CreateTaskHandler;
use App\Listeners\CreateTeamHandler;
use App\Listeners\DeleteCategoryTasks;
use App\Listeners\DeleteDepartmentUsers;
use App\Listeners\DeleteProjectTasks;
use App\Listeners\DeleteTeamProjects;
use App\Listeners\DeleteUserTasks;
use App\Listeners\UpdateCategoryHandler;
use App\Listeners\UpdateDepartmentHandler;
use App\Listeners\UpdateProjectHandler;
use App\Listeners\UpdateTaskHandler;
use App\Listeners\UpdateTeamHandler;
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
        ProjectCreated::class => [
            CreateProjectHandler::class,
        ],
        ProjectDeleted::class => [
            DeleteProjectTasks::class,
        ],
        ProjectUpdated::class => [
            UpdateProjectHandler::class,
        ],
        TeamDeleted::class => [
            DeleteTeamProjects::class,
        ],
        CategoryDeleted::class => [
            DeleteCategoryTasks::class,
        ],
        DepartmentCreated::class => [
            CreateDepartmentHandler::class,
        ],
        DepartmentUpdated::class => [
            UpdateDepartmentHandler::class,
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
        TaskCreated::class => [
            CreateTaskHandler::class,
        ],
        TaskUpdated::class => [
            UpdateTaskHandler::class,
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
