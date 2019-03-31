<?php

namespace app\common\model;


use think\Db;
use think\facade\Log;

class User extends Base
{

    protected $pk = 'uid';

    public function userAuth()
    {
        return $this->hasMany('UserOauth', 'uid', 'uid');
    }

    /**
     * 用户登录模型
     * @param $param
     * @param int $type
     * @return array|int|mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function login($param, $type = 1)
    {
        $user = array();
        $auth = array();
        switch ($type) {
//            case 1:
//                $auth['identity_type'] = 'username';
//                $auth['identifier'] = $param['username'];
//                break;
//            case 2:
//                $auth['identity_type'] = 'email';
//                $auth['identifier'] = $param['username'];
//                break;
//            case 3:
//                $auth['identity_type'] = 'mobile';
//                $auth['identifier'] = $param['username'];
//                break;
            case 4: //第三方登录
                $auth['type'] = $param['username'];
                $auth['oauthid'] = $param['password']['openid'];
                break;
        }

        $user = $this->userAuth()->where($auth)->find();
        if (isset($user['uid']) && $user['uid']) {
            $data = array(
                'uid' => $user['uid'],
                'nickname' => $user['nickname'],
                'avatar' => $user['avatar'],
                'phone' => $user['phone'],
//                'inviter_code' => $this->where('uid',$user['uid'])->value('inviter_code'),
            );
        } else {
            $inviter_code = null;
            $user['nickname'] = 'rx_'. rand_string(8);
            $user['gender'] = 1;
            $user['avatar'] = 'http://thirdwx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTKUOC0ftZuklEBhfKc90VVlfdOSdy4fF92qtITzhaMQATCjAqRpFbNP8JibD74DkxfNvVMicL1aKcnw/0';
            if ($type == 2) {
                $user['email'] = $param['username'];
            } elseif ($type == 3) {
                $user['mobile'] = $param['username'];
            } elseif ($type == 4) {
                $user['nickname'] = $param['username']['nick'];
                $user['gender'] = $param['username']['gender'];
                $user['avatar'] = $param['username']['avatar'];
            }
//            if (isset($param['inviter_code']) && $param['inviter_code'] != '') {
//                $inviter_code = $param['inviter_code'];
//            }
            $data = $this->register($auth, $user, $inviter_code);
        }
        return $data;
    }

    /**
     * 注册
     * @param $auth
     * @param array $user
     * @return int|mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function register($auth, $user = [], $inviter_code = null)
    {
//        $auth['salt'] = rand_string(6);
//        $user['inviter_code'] = createInviteCode();
//        if ($auth['identity_type'] === 'username') {
//            $auth['credential'] = md5($auth['credential'] . $auth['salt']);
//        }
        $this->startTrans();
        try {
            $this->save($user);
            $auth['uid'] = $this->uid;
            $this->userAuth()->save($auth);
//            if ($inviter_code) {
//                $data = array(
//                    'uid' => $auth['uid'],
//                    'inviter' => $this->where('inviter_code', $inviter_code)->value('uid'),
//                    'status' => 1,
//                    'create_timestamp' => date('Y-m-d H:i:s')
//                );
//                $this->invitation()->save($data);
//            }
            $this->commit();
            return array(
                'uid' => $this->uid,
                'inviter_code' => $user['inviter_code'],
            );
        } catch (\Exception $e) {
            $this->rollback();
            return -1;
        }
    }


    public function logout()
    {
        session('user_auth', null);
        session('user_auth_sign', null);
    }

    public function getInfo($uid)
    {
        $data = $this->where(array('uid' => $uid))->find();
        return $data;
    }
}
