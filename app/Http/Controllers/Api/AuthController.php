<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;

class AuthController extends AbstractApiController
{
    /*
    * validate token, if valid return username
    */
    public function user() {
        $user = auth()->user();

        return $this->response([
            'username' => $user->username
        ]);
    }

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
                $objToken = auth()->user()->createToken(Config::get("app.key"));

                return $this->response([
                    'token' => $objToken->accessToken,
                    'expiresAt' => $objToken->token->expires_at
                ]);
            }
        } 
        
        return $this->responseNOK('Unauthorised');
    }
}