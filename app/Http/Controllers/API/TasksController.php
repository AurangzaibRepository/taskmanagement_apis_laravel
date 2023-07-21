<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\TaskAllRequest;
use App\Http\Requests\TaskListingRequest;
use App\Http\Requests\ShowTaskRequest;
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

    public function listing(TaskListingRequest $request): JsonResponse
    {
        $data = $this->task->getListing($request);

        return getResponse(true, $data);
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $data = $this->task->saveRecord($request->all());

        return getResponse(true, $data);
    }

    public function show(ShowTaskRequest $request, int $id): JsonResponse
    {
        $data = $this->task->getData($id);

        return getResponse(true, $data);
    }

    public function update(UpdateTaskRequest $request, int $id): JsonResponse
    {
        $this->task->updateRecord($request);

        return getResponse(true, null, 'Task updated successfully');
    }

    public function destroy(DeleteTaskRequest $request, int $id): JsonResponse
    {
        $this->task->deleteRecord($id);

        return getResponse(true, null, 'Task deleted successfully');
    }
}
