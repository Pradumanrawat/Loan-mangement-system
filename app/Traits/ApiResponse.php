<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

/**
 * Provides consistent JSON response structure for REST API endpoints.
 */
trait ApiResponse
{
    protected function successResponse(string $message, mixed $data = null, int $code = 200): JsonResponse
    {
        $response = ['message' => $message];

        if ($data !== null) {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }

    protected function errorResponse(string $message, int $code = 400, array $errors = []): JsonResponse
    {
        $response = ['message' => $message];

        if ($errors !== []) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }
}
