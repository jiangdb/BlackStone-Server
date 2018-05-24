<?php

namespace App\Http\Controllers\Api\V2;

use App\Services\WeiXinService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends ApiController
{
    private function weChatMiniProgramLogin(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);
        $wxService = new WeiXinService();
        $res = $wxService->code2session($request->input('code'));
        if ($res==null) {
            return $this->responseErrorWithMessage('can\'t get session from weixin');
        }
        if (isset($res->errcode)){
            return $this->responseErrorWithMessage($res->errmsg);
        }
        $datas = [
            'open_id'  => $res->openid,
            'union_id' => isset($res->unionid)?$res->unionid:null,
        ];
        return User::findOrCreateByPlatform(User::PLATFORM_WEIXIN, $datas);
    }

    private function weChatAppLogin(Request $request)
    {
        $this->validate($request, [
            'openId' => 'required',
        ]);
        $datas = [
            'open_id'  => $request->openId,
            'union_id' => null
        ];
        return User::findOrCreateByPlatform(User::PLATFORM_WEIXIN, $datas);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'client' => [
                'required',
                Rule::in(['weChatMiniProgram','weChatApp']),
            ],
        ]);

        $user = null;
        switch ($request->client) {
            case 'weChatMiniProgram':
                $user = $this->weChatMiniProgramLogin($request);
                break;
            case 'weChatApp':
                $user = $this->weChatAppLogin($request);
                break;
            default:
                break;
        }

        if ($user) {
            $token = JWTAuth::fromUser($user);
            return $this->responseSuccessWithExtrasAndMessage([
                'token'    => $token,
                'expireAt' => Carbon::now()->timestamp + config('jwt.ttl') * 60,
                'refreshExpireAt' => Carbon::now()->timestamp + config('jwt.refresh_ttl') * 60
            ]);
        }
        return $this->responseNotAllowedWithMessage();
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'client' => [
                'required',
                Rule::in(['weChatMiniProgram','weChatApp']),
            ],
        ]);

        $user = JWTAuth::parseToken()->authenticate();
        if ($request->has('nickname') && ($request->nickname != $user->name)) {
            $user->name = $request->nickname;
            $user->save();
        }

        $user_platform = $user->wx_user;
        $user_platform->nickname = $request->nickname;
        $user_platform->gender = $request->gender;
        $user_platform->city = $request->city;
        $user_platform->province = $request->province;
        $user_platform->avatar_url = $request->avatar_url;
        if ($user_platform->isDirty()) {
            $user_platform->save();
        }else{
            $user_platform->touch();
        }
        return $this->responseSuccess();
    }

}
