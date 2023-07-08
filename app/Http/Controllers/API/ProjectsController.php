<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectAllRequest;
use App\Http\Requests\ShowProjectRequest;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
    public function listing()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
