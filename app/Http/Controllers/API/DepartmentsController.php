<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteDepartmentRequest;
use App\Http\Requests\DepartmentAllRequest;
use App\Http\Requests\DepartmentListingRequest;
use App\Http\Requests\ShowDepartmentRequest;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
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

    public function listing(DepartmentListingRequest $request): JsonResponse
    {
        $data = $this->department->getListing($request);

        return getResponse(true, $data);
    }

    public function store(StoreDepartmentRequest $request): JsonResponse
    {
        $data = $this->department->saveRecord($request->all());

        return getResponse(true, $data, 'Department added successfully');
    }

    public function show(ShowDepartmentRequest $request, int $id): JsonResponse
    {
        $data = $this->department->getData($id);

        return getResponse(true, $data);
    }

    public function update(UpdateDepartmentRequest $request, int $id): JsonResponse
    {
        $this->department->updateRecord($request);

        return getResponse(true, null, 'Department updated successfully');
    }

    public function destroy(DeleteDepartmentRequest $request, int $id): JsonResponse
    {
        $this->department->deleteRecord($id);

        return getResponse(true, null, 'Department deleted successfully');
    }
}
