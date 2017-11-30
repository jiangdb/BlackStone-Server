<?php

namespace App\Http\Controllers\Api\V1;

use App\Services\WeiXinService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends ApiController
{
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
                'email'    => $res->openid.'@bm.com',
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
            'expireAt' => Carbon::now()->timestamp + config('jwt.refresh_ttl') * 60
        ]);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'user_type' => [
                'required',
                Rule::in( array_keys(User::$support_platforms) ),
            ],
        ]);

        $user = JWTAuth::parseToken()->authenticate();
        if ($request->has('nickname')) {
            $user->name = $request->nickname;
            $user->save();
        }

        $user_type = $request->user_type;
        $user->$user_type()->update($request->only([
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
