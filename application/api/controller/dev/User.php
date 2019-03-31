<?php

namespace app\api\controller\dev;


use think\facade\Log;

class User extends Base
{

    public function index()
    {
        //
    }

    /**
     * 获取验证码，保存手机号
     */
    public function verify(){
        if($this->request->isPost()){

        }else{

        }
    }

    /**
     * 获取/修改用户信息
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function userInfo()
    {
        if($this->request->isPost()){
            $this->data['data'] = model('User')->allowField(true)->save($this->params['userinfo'],['uid', $this->params['uid']]);
        }else{
            $this->data['data'] = model('User')->field('nickname,avatar')->where('uid', $this->params['uid'])->find();
            return json($this->data);
        }
    }

    /**
     * 获取用户邀请列表
     * @param $uid
     * @return array|int|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getInvitation()
    {
        $this->data = model('User')->hasWhere('invitation', ['inviter' => $this->params['uid']])->select()->toArray();
        return json($this->data);
    }

}
