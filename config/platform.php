<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | 第三方应用设置
// | 微信     101
// | 支付宝   102
// +----------------------------------------------------------------------
return [
    'weixin' => array(
        'app_id' => 'wxaa8a33b49817c391',//oaogms
        'app_secret' => '2018c07f6ed74063b9acd73ced359486',
        'encodingaeskey' => 'BYx1ro0YhMXalUJTbtsvpNVkrOGPcEafV0MbuYecXIl',
        'token' => 'hippo',
        'scope' => 'snsapi_userinfo',//如果需要静默授权，这里改成snsapi_base，扫码登录系统会自动改为snsapi_login
        'mch_id' => 'snsapi_base',//如果需要静默授权，这里改成snsapi_base，扫码登录系统会自动改为snsapi_login
        'mch_secret' => 'snsapi_base',//如果需要静默授权，这里改成snsapi_base，扫码登录系统会自动改为snsapi_login
        'whost' => array(
            'login' => 'https://api.weixin.qq.com/sns/jscode2session',
            'aqrcode' => 'https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode',
            'acode' => 'https://api.weixin.qq.com/wxa/getwxacode',
            'checksession' => 'https://api.weixin.qq.com/wxa/checksession',
            'access' => 'https://api.weixin.qq.com/cgi-bin/token',
            'pay' => 'https://api.mch.weixin.qq.com/pay/unifiedorder',
            'transfers' => 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers',
            'acodeunlimit' => 'https://api.weixin.qq.com/wxa/getwxacodeunlimit',
        )
    ),
];
