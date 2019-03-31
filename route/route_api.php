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


use think\facade\Route;

Route::group('dev',array(
    '/'                     => 'api/dev.index/index',
    'login'                 => 'api/dev.index/login',
    'notify/login'          => 'api/dev.notify/sns',
    'getAccessToken'        => 'api/dev.index/accessToken',
    'getBanners'            => 'api/dev.index/banner',
    'getArticle'            => 'api/dev.index/article',
    'getSocialLimit'        => 'api/dev.index/socialLimit',
));

Route::group('dev',array(
    'getCalcBill'           => 'api/dev.index/calcBill',
    'getConfig'           => 'api/dev.index/getJsSdkConf',
))->middleware(['Check']);

Route::group('dev/order',array(
    'list'                  => 'api/dev.order/index',
    'save'                  => 'api/dev.order/order',
    'detail'                => 'api/dev.order/detail',
    'delete'                => 'api/dev.order/delete',
    'payment'               => 'api/dev.order/pay',
))->middleware(['Check']);

Route::group('dev/user',array(
    'getInfo'               => 'api/dev.user/userInfo',
    'getInvitation'         => 'api/dev.user/getInvitation',
    'getSocial'             => 'api/dev.user/socialSecurity',
    'getfund'               => 'api/dev.user/fund',
    'saveBase'              => 'api/dev.user/baseInfo',
))->middleware(['Check']);

Route::group('dev/notify',array(
    'wxpay'                => 'api/dev.notify/weixin',
))->middleware(['Check']);