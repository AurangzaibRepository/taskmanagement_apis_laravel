<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;
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

        return getResponse(true, $user->toArray());
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $this->user->updatePassword($request);

        return getResponse(true, null, 'Password changed successfully');
    }

    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $this->user->generateVerificationCode($request->email);

        return getResponse(true, null, 'Email sent to your email for verification');
    }
}
