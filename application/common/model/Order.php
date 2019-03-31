<?php

namespace app\common\model;


use think\Db;
use think\facade\Cache;

class Order extends Base
{

    protected $pk = 'id';

    public function orderInfo()
    {
        return $this->hasOne('OrderInfo', 'order_id');
    }

    public function payInfo()
    {
        return $this->hasOne('Payment', 'order_id');
    }

    /**
     * 创建订单及支付订单
     * @param $order_data
     * @param $order_info
     * @return bool
     * @throws \think\exception\PDOException
     */
    public function saveOrder($data)
    {
        $this->startTrans();
        try {
            //订单信息
            $order_no = createOrderId();
            $this->save(array(
                'uid'=>$data['uid'],
                'order_no'=>$order_no,
                'addr'=>$data['addr'],
                'postage'=>$data['postage'],
                'status'=>1,
                'close_timestamp'=>date('Y-m-d H:i:s',strtotime("+30 minute")),
            ));
            $this->orderInfo()->save(array(
                'uid'=>$data['uid'],
                'pid'=>$data['goods_id'],
                'cid'=>$data['coupon_id'],
                'order_no'=>$order_no,
                'name'=>$data['name'],
                'image'=>$data['image'],
                'price'=>$data['price'],
                'num'=>$data['num'],
                'postage'=>$data['postage'],
                'total'=>$data['total'],
                'payment'=>$data['payment']
            ));
            $this->payInfo()->save(array(
                'uid' => $data['uid'],
                'order_no'=>$order_no,
                'pay_status' => 0,
            ));
            // 提交事务
            $this->commit();
            return true;
        } catch (\Exception $e) {
            // 回滚事务
            $this->rollback();
            return false;
        }
    }

    /**
     * @param $payinfo
     * @return bool
     * @throws \think\exception\PDOException
     */
    public function checkOrderAndChangeStatus($payinfo)
    {
        $this->startTrans();
        try {
            $order_data = $this->where('order_sn', $payinfo['order_sn'])->find();
            #TODO 发放缴费券并扣除一张
            $params = array(
                'uid' => $order_data['uid'],
                'coupon_id' => $this->orderInfo->fund_basic == '0' ? 2 : 3,
                'order_id' => $this->id,
                'service_type' => $order_data['service_type'],//缴费类型
            );
            $coupon_id = model('Coupon')->grantDeductionCoupon($params);
            #TODO 检查邀请信息
            if (($inviter = model('InviteRelation')->where([['uid', '=', $payinfo['uid'], ['status', '=', 1]]])->value('inviter')) && $inviter > 0) {
                model('InviteRelation')->where([['uid', '=', $payinfo['uid'], ['inviter', '=', $inviter]]])->update(array('status' => 2));
            }
            #TODO 改变订单状态
            $end = date('Y-m-d H:i:s', strtotime('+30minutes'));
            $this->save(array(
                ['pay_timestamp', '=', date('Y-m-d H:i:s')],
                ['end_timestamp', '=', $end],
                ['status', '=', 2],
            ), ['order_sn', '=', $payinfo['order_sn']]);
            $this->payInfo()->where('', '=', $payinfo['id'])->update(array(
                'pay_platform' => 'weixin',
                'coupon' => $coupon_id,
                'pay_no' => $payinfo['pay_no'],
                'pay_status' => 1,
            ));
            #TODO 记录订单状态
            $log = array(
                'uid' => $payinfo['uid'],
                'title' => '订单支付',
                'remark' => $payinfo['order_sn'] . '订单支付成功'
            );
            // 提交事务
            $this->commit();
            $result = true;
        } catch (\Exception $e) {
            // 回滚事务
            $log = array(
                'uid' => $payinfo['uid'],
                'title' => '订单支付',
                'remark' => $payinfo['order_sn'] . '订单支付失败'
            );
            $this->rollback();
            $result = false;
        }
        model('Action')->save($log);
        return $result;
    }
}
