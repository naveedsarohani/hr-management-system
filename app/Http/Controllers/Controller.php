<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    // method to generate success response
    protected function successResponse(int $StatusCode, string $message, array $dataContent = null)
    {
        $responseData = [
            'status' => true,
            'message' => $message,
        ];

        if ($dataContent && is_array($dataContent)) {
            $responseData[array_keys($dataContent)[0]] = array_values($dataContent)[0];
        }

        return response()->json($responseData, $StatusCode);
    }

    // method to genrate error response
    protected function errorResponse(int $StatusCode, string $message, array|string $dataContent = null)
    {
        $responseData = [
            'status' => false,
            'message' => $message,
        ];

        if ($dataContent && is_array($dataContent)) {
            $responseData['errors'] = array_map(function ($message) {
                return $message[0];
            }, $dataContent);
        }

        if ($dataContent && is_string($dataContent)) {
            $responseData['error'] = $dataContent;
        }

        return response()->json($responseData, $StatusCode);
    }
}
