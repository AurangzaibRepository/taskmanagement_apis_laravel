<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectAllRequest;
use App\Http\Requests\ProjectListingRequest;
use App\Http\Requests\ShowProjectRequest;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Http\JsonResponse;

class ProjectsController extends Controller
{
    public function __construct(
        private Project $project,
    ) {
    }

    public function all(ProjectAllRequest $request, int $teamId): JsonResponse
    {
        $data = $this->project->getAll($teamId);

        return getResponse(true, $data);
    }

    /**
     * Display a listing of the resource.
     */
    public function listing(ProjectListingRequest $request): JsonRespone 
    {
        $data = $this->project->getListing($request);

        return getResponse(true, $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $this->project->saveRecord($request->all());

        return getResponse(true, $data, 'Project added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(ShowProjectRequest $request, string $id)
    {
        $data = $this->project->getData($id);

        return getResponse(true, $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, string $id)
    {
        $this->project->updateRecord($request);

        return getResponse(true, null, 'Project updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
