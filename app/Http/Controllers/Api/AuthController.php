<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;

class AuthController extends AbstractApiController
{
    /**
     * handle login request
     */
    public function login(Request $request)
    {
        $data = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (auth()->attempt($data)) {
            $user = auth()->user();
            if ($user->isAdmin()) {
                $token = auth()->user()->createToken(Config::get("app.key"))->accessToken;

                return $this->response(['token' => $token]);
            }
        } 
        
        return $this->responseNOK('Unauthorised');
    }
}