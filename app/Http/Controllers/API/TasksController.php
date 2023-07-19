<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Task;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function __construct(
        private Task $task,
    ) {
    }

    public function all(int $projectId): JsonResponse
    {
    }
}
