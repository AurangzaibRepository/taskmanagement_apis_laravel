<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Department;

class DepartmentsController extends Controller
{
    public function __construct(
        private Department $department,
    ) {
    }

    public function all(int $teamId): JsonResponse
    {
        $data = $this->department->getAll($teamId);

        return getResponse(true, $data);
    }
}
