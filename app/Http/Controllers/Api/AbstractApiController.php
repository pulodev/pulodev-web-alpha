<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class AbstractApiController extends Controller
{
    protected const MAX_PAGE_LIMIT = 90000;

    protected function responseOK() {
        return $this->sendResponse(['success' => true], 200);
    } 

    protected function response($data, $pagination = []) {
        $reponseData = [
            'success' => true,
            'data' => $data,
        ];

        if($pagination) {
            $reponseData['pagination'] = $pagination;
        }

        return $this->sendResponse($reponseData, 200);
    }

    protected function responseNOK($errorMessage, $data = []) {
        return $this->sendResponse([
            'success' => false,
            'data' => $data,
            'message' => $errorMessage
        ], 401);
    }

    private function sendResponse($data, $httpCode) {
        return response()->json($data, $httpCode);
    }
}