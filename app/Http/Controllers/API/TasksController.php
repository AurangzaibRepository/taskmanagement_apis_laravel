<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\TaskAllRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;

class TasksController extends Controller
{
    public function __construct(
        private Task $task,
    ) {
    }

    public function all(TaskAllRequest $request, int $projectId): JsonResponse
    {
        $data = $this->task->getAll($projectId);

        return getResponse(true, $data);
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $data = $this->task->saveRecord($request->all());

        return getResponse(true, $data);
    }

    public function update(UpdateTaskRequest $request, int $id): JsonResponse
    {
        $this->task->updateRecord($request);

        return getResponse(true, null, 'Task updated successfuly');
    }
}
