<?php

namespace app\api\validate;

use think\Validate;

class CalcBill extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     * @param  $residence_type @户口类型 必须
     * @param  $service_type @服务费档次 必须
     * @param  $social_basic @社保基数 必须 0为默认
     * @param  $fund_basic @公积金基数 可选 0为默认
     * @var array
     */	
	protected $rule = [
        'residence_type'  => 'require',
        'service_type'   => 'require',
        'social_basic' => 'require',
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'residence_type.require' => '户口类型必须',
        'service_type.require' => '服务费必须',
        'social_basic.require' => '社保缴费基数必须',
    ];
}
