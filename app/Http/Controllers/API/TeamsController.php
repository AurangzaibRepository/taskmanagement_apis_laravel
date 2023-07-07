<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteTeamRequest;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\TeamListingRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Team;
use Illuminate\Http\JsonResponse;

class TeamsController extends Controller
{
    public function __construct(
        private Team $team
    ) {
    }

    public function all(): JsonResponse
    {
        $data = $this->team->getAll();

        return getResponse(true, $data);
    }

    public function listing(
        TeamListingRequest $request,
        int $pageNumber,
        string $code = '',
        string $name = ''
    ): JsonResponse {
        $data = $this->team->getListing($request);

        return getResponse(true, $data);
    }

    public function store(StoreTeamRequest $request): JsonResponse
    {
        $this->team->saveRecord($request);

        return getResponse(true, null, 'Team added successfully');
    }

    public function update(UpdateTeamRequest $request, string $id): JsonResponse
    {
        $this->team->updateRecord($request);

        return getResponse(true, null, 'Team updated successfully');
    }

    public function destroy(DeleteTeamRequest $request, string $id): JsonResponse
    {
        $this->team->deleteRecord($id);

        return getResponse(true, null, 'Team deleted successfully');
    }
}
