<?php
/**
 * Created by PhpStorm.
 * User: jiangdongbin
 * Date: 25/12/2017
 * Time: 14:43
 */

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
use Illuminate\Support\Facades\Log;

class BadiduMapService
{
    private $client;
    private $tag = '[BD Map Service]: ';

    const API_MAP_LOCALTION_IP = 'location/ip';

    function __construct()
    {
        $this->client = new Client();
    }

    public function queryLocationByIp($ip)
    {
        //https://api.map.baidu.com/location/ip?ip=xx.xx.xx.xx&ak=您的AK&coor=bd09ll
        Log::debug($this->tag.'queryLocationByIp('.$ip.')');
        try {
            $res = $this->client->request('GET', config('baidu.host').self::API_MAP_LOCALTION_IP,[
                'query' => [
                    'ip'      => $ip,
                    'ak'      => config('baidu.map_app_secret'),
                    'coor'    => 'bd09ll',
                ],
            ]);
            return json_decode($res->getBody()->getContents());
        }catch(RequestException $e) {
            Log::error($this->tag.'RequestException: '.$e->getMessage());
            if ($e->hasResponse()) {
                Log::error($this->tag.Psr7\str($e->getResponse()));
                Log::error($this->tag. "\n" . $e->getTraceAsString());
            }
            return null;
        }
    }

}