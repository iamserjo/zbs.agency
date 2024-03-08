<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function makeJsonResponse(string $message, int $code, array $data = []): JsonResponse
    {
        return response()->json(array_merge(['message' => $message], $data), $code);
    }

    protected function makeErrorResponse(string $message, \Exception $e, int $code): JsonResponse
    {
        return response()->json(['message' => $message, 'error' => $e->getMessage()], $code);
    }
}
