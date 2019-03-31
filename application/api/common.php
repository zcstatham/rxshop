<?php

/**
 * 24位订单号 = 14位日期 + 8位随机数 + 2位检查码
 * @return string
 * @throws Exception
 */
function createOrderId()
{
    $date = date('YmdHis');
    $rand = random_int(10000000, 99999999);
    $main = $date . $rand;

    $len = strlen($main);
    $sum = 0;
    for ($i = 0; $i < $len; $i++) {
        $sum += (int)(substr($len, $i, 1));
    }
    $pad = str_pad((100 - $sum % 100) % 100, 2, '0', STR_PAD_LEFT);
    return (string)$main . $pad;
}

/**
 * 邀请码
 * @param int $len
 * @param int $times
 * @return string
 * @throws \think\db\exception\DataNotFoundException
 * @throws \think\db\exception\ModelNotFoundException
 * @throws \think\exception\DbException
 */
function createInviteCode($len = 6, $times = 0)
{
    $str = rand_string($len);
    $times++;
    if (model('User')->where('inviter_code', $str)->find()) {
        if($times>=2){
            $len += 2;
        }
        $str = createInviteCode($len, $times);
    }
    return $str;
}

/**
 * 异常处理函数
 * @param string $code
 * @param string $msg
 */
function json_error_exception($code = '', $msg = '')
{
    $error = config('errorCode.');
    $errorCode = isset($error[$code]) ? $code : 10000;
    $errorMsg = $msg != '' ? (isset($error[$code]) ? $error[$code] . " :" . $msg : $msg) : (isset($error[$code]) ? $error[$code] : "请求错误");
    return array('code' => $errorCode, 'msg' => $errorMsg);
}