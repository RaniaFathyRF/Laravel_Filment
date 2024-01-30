<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

Trait ApiResponse
{
    public static function ResponseSuccess(?array $data = null, ?string $message = 'Success', int $statusCode = 200): JsonResponse
    {
        return self::jsonResponse($data, $message, $statusCode,'success',null);
    }

    private static function jsonResponse(?array $data, ?string $message, int $statusCode,string $status,$error): JsonResponse
    {
        return response()->json([
            'status'  => $status,
            'message' => $message,
            'data'    => $data,
            'error'   => $error
        ], $statusCode);
    }

    public static function ResponseFail(?array $error = null, ?string $message = 'Failed', int $statusCode = 400): JsonResponse
    {
        return self::jsonResponse([],$message, $statusCode,'fail',$error);
    }
}
