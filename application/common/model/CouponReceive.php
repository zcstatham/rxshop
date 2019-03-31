<?php

namespace app\common\model;

use think\Model;

class CouponReceive extends Model
{
    //
    /**
     * 获取用户可使用优惠券
     * @param $uid
     * @return array|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getUserCanUseCoupon($uid, $money)
    {
        $map = [];
        $mapOr = [];
        $map[] = ['status', '=', 1];
        $map[] = ['end_timestamp', '>=', date('Y-m-d H:i:s')];
        $mapOr[] = ['substring_index(money,`/`,1)', '>=', $money];
        $mapOr[] = ['type', 'in', [2, 3]];
        return $this->where($map)
            ->whereOr($mapOr)
            ->order('end_timestamp')
            ->select();
    }

    /**
     * 获取优惠券
     * @param $coupon_id
     * @return array|null|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getCouponById($coupon_id)
    {
        return $this->where(array(
            ['id', '=', $coupon_id],
            ['status', '=', 1],
            ['end_timestamp', '>=', date('Y-m-d H:i:s')],
        ))->find();
    }
}
