<?php

namespace App\Http\Controllers\Api\V1;

use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;

class TokenController extends ApiController
{
    public function refresh()
    {
        try {
            $newToken = JWTAuth::parseToken()->refresh();
        } catch (TokenExpiredException $e) {
            return $this->setStatusCode($e->getStatusCode())
                ->response([
                        'status' => self::STATUS_ERROR,
                        'message' => 'token_expired',
                    ]
                );
        } catch (JWTException $e) {
            return $this->setStatusCode($e->getStatusCode())
                ->response([
                        'status' => self::STATUS_ERROR,
                        'message' => 'token_invalid',
                    ]
                );
        }

        return $this->responseSuccessWithExtrasAndMessage([
            'token'    => $newToken,
            'expireAt' => JWTAuth::getPayload($newToken)->get('exp')
        ]);
    }

    public function get() {
        $user = User::find(3);
        $token = JWTAuth::fromUser($user);
        return $this->responseSuccessWithExtrasAndMessage([
            'token'    => $token,
            'expireAt' => JWTAuth::getPayload($token)->get('exp')
        ]);
    }

    public function test() {
        return $this->responseSuccess();
    }
}
