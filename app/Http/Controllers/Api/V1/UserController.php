<?php

namespace App\Http\Controllers\Api\V1;

use App\Services\WeiXinService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends ApiController
{
    function __construct()
    {
    }

    public function login(Request $request, WeiXinService $wxService)
    {
        if (!$request->filled('code')) {
            return $this->responseNotAllowedWithMessage();
        }

        $res = $wxService->code2session($request->input('code'));
        if ($res==null) {
            return $this->responseErrorWithMessage('can\'t get session from weixin');
        }
        if (isset($res->errcode)){
            return $this->responseErrorWithMessage($res->errmsg);
        }

        $user = User::wherehas('wx_user', function($query) use ($res){
            $query->where('open_id', $res->openid);
        })->first();

        if ($user == null) {
            $user = User::create([
                'name'     => 'auto',
                'email'    => 'auto@localhost.com',
                'password' => Hash::make(str_random(16))
            ]);
            $user->wx_user()->create([
                'open_id' => $res->openid,
                'union_id' => isset($res->unionid)?$res->unionid:null
            ]);
        }

        $token = JWTAuth::fromUser($user);
        return $this->responseSuccessWithExtrasAndMessage([
            'token'    => $token,
            'expireAt' => JWTAuth::getPayload($token)->get('exp')
        ]);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'user_type' => [
                'required',
                Rule::in(['weixin']),
            ],
        ]);

        $user = JWTAuth::parseToken()->authenticate();
        $user->wx_user()->update($request->only([
            'nickname',
            'gender',
            'city',
            'province',
            'country',
            'avatar_url',
        ]));

        return $this->responseSuccess();
    }

}
