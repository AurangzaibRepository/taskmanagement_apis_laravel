<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentAllRequest;
use App\Models\Department;
use Illuminate\Http\JsonResponse;

class DepartmentsController extends Controller
{
    public function __construct(
        private Department $department,
    ) {
    }

    public function all(DepartmentAllRequest $request, int $teamId): JsonResponse
    {
        $data = $this->department->getAll($teamId);

        return getResponse(true, $data);
    }
}
