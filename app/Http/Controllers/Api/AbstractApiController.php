<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class AbstractApiController extends Controller
{
    protected function responseOK() {
        return $this->sendResponse(['success' => true], 200);
    } 

    protected function response($data) {
        return $this->sendResponse([
            'success' => true,
            'data' => $data,
        ], 200);
    }

    protected function responseNOK($errorMessage) {
        return $this->sendResponse([
            'success' => false,
            'data' => [],
            'message' => $errorMessage
        ], 401);
    }

    private function sendResponse($data, $httpCode) {
        return response()->json($data, $httpCode);
    }
}