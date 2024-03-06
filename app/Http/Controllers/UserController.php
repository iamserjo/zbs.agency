<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;
use App\Services\UserRegistrationService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private readonly UserRegistrationService $userRegistrationService)
    {
    }

    public function register(UserRegistrationRequest $request): JsonResponse
    {
        $token = $request->header('Authorization');

        if (!$this->validateToken($token)) {
            return response()->json(['message' => 'Invalid or expired token'], 401);
        }

        $validatedData = $request->validated();

        // Validation passed, proceed with registration logic
        try {
            $user = $this->userRegistrationService->register($validatedData);
            Cache::delete('registration_token_' . $token);
            return response()->json([
                'message' => 'User registered successfully',
                'user' => $user,
            ], 201);
        } catch (\Exception $e) {
            // Handle  unexpected exceptions
            return response()->json(['message' => 'Failed to register user', 'error' => $e->getMessage()], 500);
        }
    }

    private function validateToken($token): bool
    {
        if (!$token) {
            return false;
        }

        return Cache::has('registration_token_' . $token);
    }

    public function generateToken(): JsonResponse
    {
        $token = Str::random(60);
        $expiresAt = now()->addMinutes(40);

        Cache::put('registration_token_' . $token, true, $expiresAt);

        return response()->json([
            'token' => $token,
            'expires_at' => $expiresAt->toDateTimeString(),
        ]);
    }

    public function getUserById(User $user): User
    {
        return $user;
    }

    public function getUsers(Request $request): JsonResponse
    {

        /** @var Builder $usersQuery */
        $usersQuery = User::orderBy('created_at', 'desc');

        $offset = $request->input('offset');

        if ($offset) {
            $usersQuery->offset($offset);
        } else {
            $usersQuery->forPage($request->input('page', 1));
        }

        return response()->json(
            $usersQuery->paginate($request->input('count', 10))
        );
    }
}
