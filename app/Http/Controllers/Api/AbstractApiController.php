<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class AbstractApiController extends Controller
{
    protected const MAX_PAGE_LIMIT = 90000;

    protected function responseOK($data = null) {
        $dataResp = ['success' => true];
        if($data!==null)
            $dataResp['data'] = $data;

        return $this->sendResponse($dataResp, 200);
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