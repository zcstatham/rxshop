<?php

namespace app\common\model;

use think\Model;

class Coupon extends Model
{

    public function couponReceive()
    {
        return $this->hasMany('CouponReceive', 'coupon_id');
    }

    /**
     * 发放打折券
     * @param $params
     * @throws \Exception
     */
    public function grantDiscountsCoupon($params)
    {
        $CouponReceive = model('CouponReceive');
        if ($params['discounts'] && $CouponReceive->where(array(
                'uid' => $params['uid'],
                'coupon_id' => 1,
                'coupon_type' => 1,
            ))->find()->isEmpty()) {
            //发放半价券并锁定
            $CouponReceive->save(array(
                'uid' => $params['uid'],
                'coupon_id' => 1,
                'coupon_type' => 1,
                'status' => 2,
            ));
        }
    }

    /**
     * 发放缴费券
     * @param $params
     * @throws \Exception
     */
    public function grantDeductionCoupon($params)
    {
        $coupon = $this->get($params['coupon_id']);
        $couponReceive = model('CouponReceive');
        $data = [];
        switch ($params['service_type']) {
            case 'monthly':
                $num = 1;
                break;
            case 'seasonal':
                $num = 3;
                break;
            case 'halfYearly':
                $num = 6;
                break;
            case 'yearly':
                $num = 12;
                break;
            default:
                $num = 1;
                break;
        }
        for (; $num > 0; $num--) {
            array_push($data, array(
                'uid' => $params['uid'],
                'order_id' => $params['order_id'],
                'coupon_id' => $params['coupon_id'],
                'coupon_type' => $coupon->type,
                'status' => 1,
            ));
        }
        // 扣除一张缴费券
        $data[0]['status'] = 3;
        $first_id = (int)$couponReceive->getLastInsID() + 1;
        $couponReceive->saveAll($data);
        return $first_id;
    }

    /**
     * 获取并锁定缴费券
     * @param $uid
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getDeductionCoupon($uid)
    {
        $id = model('CouponReceive')->where([['uid', '=', $uid], ['status', '=', 1]])
            ->order('end_timestamp')
            ->value('id');
        return $id;
    }
}
