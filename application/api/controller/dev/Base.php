<?php
/**
 * Created by PhpStorm.
 * MiniUser: EDZ
 * Date: 2018/12/7
 * Time: 19:19
 */

namespace app\api\controller\dev;

use think\Controller;
use think\facade\Log;

class Base extends Controller
{
    public $uri;
    public $params;
    protected $data;

    protected function initialize()
    {
        $this->uri = $this->request->protocol() . ' ' . $this->request->method() . ' : ' . $this->request->url(true);
        $this->data = array(
            'code' => 1,
            'msg' => '请求成功',
            'time' => time()
        );
        $this->params = $this->checkParams();
    }

    public function checkParams()
    {
        $module = ucfirst($this->request->module());
        $controller = ucfirst($this->request->controller());
        $action = ucfirst($this->request->action());
        $params = [];
        foreach ($this->request->param() as $i => $v) {
            if (preg_match('/[A-Z]/', $i)) {
                $params[uncamelize($i)] = $v;
            } else {
                $params[$i] = $v;
            }
        }
        if (in_array("$module/$controller/$action", config('verifyApiList.'))) {
            $result = $this->validate($params, 'app\\api\\validate\\' . $action);
            if (true !== $result) {
                return json(json_error_exception('20005', $result));
            }
        }
        if (isset($this->request->userInfo['uid'])) {
            $params['uid'] = $this->request->userInfo['uid'];
            unset($params['userInfo']);
        }
        return $params;
    }
}