<?php
/**
 * Created by PhpStorm.
 * User: jiangdongbin
 * Date: 08/11/2017
 * Time: 10:44
 */

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class WeiXinService
{
    private $client;
    private $tag = '[WX Service]: ';

    function __construct()
    {
        $this->client = new Client();
    }

    function test()
    {
        try {
            $client = new Client();
            $res = $client->request('GET', 'http://bs.com/api/test');
            return json_decode($res->getBody()->getContents());
        }catch(RequestException $e) {
            Log::error($this->tag.'RequestException');
            if ($e->hasResponse()) {
                Log::error($this->tag.Psr7\str($e->getResponse()));
                Log::error($this->tag. "\n" . $e->getTraceAsString());
            }
            return null;
        }
    }

    function code2session($code)
    {
        //https://api.weixin.qq.com/sns/jscode2session?appid=APPID&secret=SECRET&js_code=JSCODE&grant_type=authorization_code
        Log::debug($this->tag.'code2session('.$code.')');
        try {
            $res = $this->client->request('GET', config('weixin.host').config('weixin.api_jscode2session'),[
                'query' => [
                    'appid'      => config('weixin.app_id'),
                    'secret'     => config('weixin.app_secret'),
                    'js_code'    => $code,
                    'grant_type' => 'authorization_code'
                ],
            ]);
            return json_decode($res->getBody()->getContents());
        }catch(RequestException $e) {
            Log::error($this->tag.'RequestException');
            if ($e->hasResponse()) {
                Log::error($this->tag.Psr7\str($e->getResponse()));
                Log::error($this->tag. "\n" . $e->getTraceAsString());
            }
            return null;
        }
    }
}