<?php
/**
 * Created by PhpStorm.
 * User: jiangdongbin
 * Date: 06/11/2017
 * Time: 20:27
 */

return [
    'app_id'                => env('WEIXIN_APP_ID',''),
    'app_secret'            => env('WEIXIN_APP_SECRET', ''),

    'host'                  => 'https://api.weixin.qq.com/',
    'api_jscode2session'    => 'sns/jscode2session',
];
