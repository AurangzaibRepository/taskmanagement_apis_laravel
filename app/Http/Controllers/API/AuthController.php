<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        private User $user,
    ) {
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)
                    ->first();
    }
}
