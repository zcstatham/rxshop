<?php

namespace app\api\validate;

use think\Validate;

class UserInfo extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'    =>    ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'realname' => ['require','regex'=>'/^[\x{4e00}-\x{9fa5}]{2,10}$/isu'],
        'social_type' => ['require', 'in' => '0,1'],
        'social_city' => 'require',
        'id_card' => 'require|idCard',
        'credit_card' => ['require', 'regex' => '/^([1-9]{1})(\d{14}|\d{18})$/'],
        'mobile' => 'require|mobile',
        'email' => 'email',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'    =>    '错误信息'
     *
     * @var array
     */
    protected $message = [
        'realname.require' => '姓名必须',
        'realname.regex' => '姓名格式错误',
        'social_type.require' => '户口类型必须',
        'social_type.in' => '户口类型错误',
        'social_city.require' => '参保城市必须',
        'id_card.require' => '身份证号必须',
        'id_card.idCard' => '身份证号格式错误',
        'credit_card.require' => '银行卡号必须',
        'credit_card.regex' => '银行卡号格式错误',
        'mobile.require' => '手机号码必须',
        'mobile.mobile' => '手机号码格式错误',
        'email.email' => '邮箱格式错误',
    ];
}
