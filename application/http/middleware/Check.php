<?php

namespace app\http\middleware;

use service\EncryptService;
use think\Response;
use think\Request;
use traits\controller\Jump;
use think\facade\Log;

class Check
{
    use Jump;

    /**
     * @param Request $request
     * @param \Closure $next
     * @return mixed|\think\response\Json
     */
    public function handle(Request $request, \Closure $next)
    {
        if($request->method() == 'OPTIONS'){
            return json('');
        }
        if($request->has('echostr')){
            $params = $request->param();
            $config = config('platform.' . $params['platform']);
            return json(SnsService::$params['platform']($config)->index($params));
        }
        $jwt = new EncryptService();
        $authorization = $request->header('Authorization');
        if (stripos($authorization, 'Bearer') !== false) {
            $authorization = explode(' ',$authorization)[1];
        }
        $checkToken = $jwt->checkToken($authorization);
        if (is_numeric($checkToken)) {
            return json(json_error_exception($checkToken));
        }
        Log::record($checkToken);
        $request->userInfo = $checkToken['params'];
        return $next($request);
    }
}
