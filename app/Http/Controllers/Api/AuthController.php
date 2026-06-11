<?php

namespace App\Http\Controllers\Api;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponse;

    public function __construct(protected UserRepositoryInterface $userRepository)
    {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['role'] = UserRole::Customer->value;

        $user = $this->userRepository->create($data);
        $token = $user->createToken('auth-token')->plainTextToken;

        return $this->successResponse('Registration successful', [
            'user' => $this->formatUser($user),
            'token' => $token,
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        /** @var User $user */
        $user = Auth::user();

        // Revoke old tokens on new login (token rotation best practice)
        $user->tokens()->delete();

        $token = $user->createToken('auth-token')->plainTextToken;

        return $this->successResponse('Login successful', [
            'user' => $this->formatUser($user),
            'token' => $token,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->successResponse('Logged out successfully');
    }

    private function formatUser(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'mobile' => $user->mobile,
            'role' => $user->role->value,
        ];
    }
}
