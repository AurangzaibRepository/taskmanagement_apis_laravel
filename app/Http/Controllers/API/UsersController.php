<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserAllRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UsersController extends Controller
{
    public function __construct(
        private User $user,
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function all(
        UserAllRequest $request,
        int $teamId,
        int $departmentId
    ): JsonResponse {

        $data = $this->user->getAll($teamId, $departmentId);

        return getResponse(true, $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $this->user->saveRecord($request);

        return getResponse(true, $data, 'User added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, int $id)
    {
        $this->user->updateRecord($request);

        return getResponse(true, null, 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
