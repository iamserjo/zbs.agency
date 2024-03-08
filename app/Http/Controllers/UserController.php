<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;
use App\Services\TokenService;
use App\Services\UserRegistrationService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private const int DEFAULT_USERS_PER_PAGE_COUNT = 10;

    public function __construct(
        private readonly UserRegistrationService $userRegistrationService,
        private readonly TokenService $tokenService,
    )
    {
    }

    public function register(UserRegistrationRequest $request): JsonResponse
    {
        $token = $request->header('Authorization');
        if (!$this->tokenService->isRegistrationTokenActive($token)) {
            return $this->makeJsonResponse('Invalid or expired token', 401);
        }
        $validatedData = $request->validated();
        // Validation passed, proceed with registration logic
        try {
            $user = $this->userRegistrationService->register($validatedData);
            $this->tokenService->deleteRegistrationToken($token);
            return $this->makeJsonResponse('User registered successfully', 201, ['user' => $user]);
        } catch (\Exception $e) {
            return $this->makeErrorResponse('Failed to register user', $e, 500);
        }
    }

    public function generateToken(): JsonResponse
    {
        $expiresAt = now()->addMinutes(config('services.token.registration_token_active_minutes'));

        $token = $this->tokenService->generateToken();
        $this->tokenService->saveRegistrationToken($token, $expiresAt);

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
        $count = $request->input('count', self::DEFAULT_USERS_PER_PAGE_COUNT);

        if ($offset = $request->input('offset')) {
            return $this->getUserOffset($usersQuery, $offset, $count);
        }

        $usersQuery->forPage($request->input('page', 1));

        return response()->json(
            $usersQuery->paginate($count)
        );
    }

    private function getUserOffset(Builder $usersQuery, int $offset, int $count): JsonResponse
    {
        $usersQuery->offset($offset);
        $usersQuery->limit($count);

        $data = $usersQuery->get()->toArray();
        return response()->json([
            'data' => $data,
            'first_page_url' => null,
            'from' => null,
            'last_page' => null,
            'last_page_url' => null,
            'next_page_url' => [],
            'links' => [],
            'path' => url()->current(),
            'per_page' => null,
            'prev_page_url' => null,
            'total' => count($data),
        ]);
    }
}
