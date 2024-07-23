<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class ApiController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function successfulResponse(mixed $data, ?String $code, ?String $message, ?int $status = 200): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'code' => $code,
            'message' => $message
        ], $status);
    }

    public function badRequestResponse(?String $code, ?String $message, ?int $status = 400): JsonResponse
    {
        return response()->json([
            'code' => $code,
            'message' => $message
        ], $status);
    }
}
