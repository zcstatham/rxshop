<?php

namespace app\api\controller\dev;


use service\snspay\SnsService;
use service\snspay\Weixin;

class Order extends Base
{

    /**
     * 获取订单列表
     * @return \think\response\Json
     * @throws \Exception
     */
    public function index()
    {
        $map[] = ['uid', '=', $this->params['uid']];
        $map[] = ['status', '=', 1];
        $field = ['order_id', 'order_sn', 'payment,status', 'creat_timestamp'];
        $order = ['update_timestamp' => 'desc'];
        $this->data['data'] = model('Orders')
            ->field($field)
            ->where($map)
            ->order($order)->select()->toArray();
        return json($this->data);
    }

    /**
     * 生成订单
     * @return \think\response\Json
     * @throws \Exception
     */
    public function create()
    {
        if (
            !isset($this->params['goods_id']) || !$this->params['goods_id'] ||
            !isset($this->params['addr']) || !$this->params['addr']
        ) {
            return json_error_exception('20301');
        }
        //获取下单商品
        $goods_info = $this->model->getProductDetail($this->params['goods_id']);
        #TODO 检查商品信息
        if (intval($goods_info['status']) != 1) {
            return json_error_exception(20302);
        }

        #TODO 检查库存
        if (intval($goods_info['stock']) == 0) {
            return json_error_exception(20303);
        }

        $orderAmount = $goods_info['price'] * $this->params['number'];
        if ($this->request->isPost()) {
            $data = $this->params;
            if (!isset($data['coupon_id']) ||
                !$data['coupon_id'] ||
                ($coupon = model('CouponReceive')->getCouponById($data['coupon_id']))->isEmpty()
            ) {
                json_error_exception(20401);
            }
            if (!isset($data['addr']) || !$data['addr']) {
                json_error_exception(20101);
            }
            if (stripos($coupon['money'], '/') !== FALSE) {
                list($a, $b) = $coupon['money'];
                $data['coupon'] = $a > $orderAmount ? 0 : $b;
            }
            $data = array_merge($data, $goods_info);
            $data['postage'] = 0;
            $data['total'] = $orderAmount + $data['postage'];
            $data['payment'] = $data['total'] - $data['coupon'];
            if (model('Order')->saveOrder($data)) {
                return json($this->data);
            } else {
                return json_error_exception('10101');
            }
        } else {
            $response['goods']['goods_id'] = $goods_info['goods_id'];
            $response['goods']['goods_name'] = $goods_info['goods_name'];
            $response['goods']['number'] = $this->params['number'];
            $response['goods']['goods_price'] = $goods_info['price'];
            $response['goods']['goods_image'] = $goods_info['image'];

            //取运费
//            $trafficPrice = 0;
//            if (isset($address['province'])) {
//                $shippingGoods = array(
//                    (int)$goods_info['shop_id'] => array(
//                        'goods_price' => $goods_price * $data['number'],
//                        'goods_number' => (int)$data['number'],
//                        'goods_heavy' => $goods_info['goods_heavy'],
//                    ),
//                );
//                $trafficPrice = getShippingFeeByGoodsGroup($address['province'], $shippingGoods);
//            }


//            $user =  model('User')->_getOneUser(array('uid='.$data['uid']));
//            if($user['balance'] > 0)
//            {
//                if(intval($user['balance']) >= $orderAmount){
//                    $balance = $orderAmount;
//                    $orderAmount = 0;
//                }else if(intval($user['balance']) < $orderAmount){
//                    $balance = $user['balance'];
//                    $orderAmount = $orderAmount  - $balance;
//                }
//            }
            //去可用优惠券
            $response['coupon'] = model('CouponReceive')
                ->getUserCanUseCouponCount($this->params['uid'], $orderAmount);

            $response['payInfo'] = array(
                'trafficPrice' => 0,
                'goodsPrice' => $goods_info['price'] * $this->params['number'],
                'payPrice' => $orderAmount,
            );
            $this->data['data'] = $response;
        }
    }

    /**
     * 订单详情
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function detail()
    {
        if (!isset($this->params['order_sn']) || !empty($this->params['order_sn']) || ($orderinfo = model('OrderInfo')->where('order_sn', $this->params['order_sn'])->find())->isEmpty()) {
            return json(json_error_exception('20101'));
        }
        $this->data['data'] = array(
            'social_basic' => $orderinfo['social_basic'],
            'fund_basic' => $orderinfo['fund_basic'],
            'charge_details' => json_decode($orderinfo['charge_details'], true),
            'service_charge' => $orderinfo['service_charge'],
            'total_charge' => $orderinfo['total_charge'],
        );
        return json($this->data);
    }

    /**
     * 删除订单-》软删除
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function delete()
    {
        if (!isset($this->params['order_sn']) || !empty($this->params['order_sn']) || empty($id = model('OrderInfo')->where('order_sn', $this->params['order_sn'])->value('id'))) {
            return json(json_error_exception('20101'));
        }
        if (!model('Orders')->save(['status', 0], ['id', $id])) {
            $this->data = json_error_exception('10101');
        }
        return json($this->data);
    }

    /**
     * 订单支付
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function pay()
    {
        $orderinfo = model('Orders')->where(array(
            ['order_sn', $this->params['order_sn']],
            ['uid', $this->params['uid']],
        ))->find();
        $payinfo = model('PayInfo')->where(array(
            ['order_sn', $this->params['order_sn']],
            ['uid', $this->params['uid']],))->find();
        if (!$orderinfo || $payinfo) {
            $this->data = json_error_exception(20102);
        }
        if ($orderinfo['status'] != 1 && $payinfo['pay_status'] != 0) {
            $this->data = json_error_exception(20103);
        }
        $name = $this->params['platform'];
        $config = config('platform.' . $name);
        $this->data = SnsService::$name($config)->pay(array(
            'order_sn' => $orderinfo['order_sn'],
            'money' => $orderinfo['payment'],
            'notify_url' => url('/notify/' . $name),
        ));
        return json($this->data);
    }
}
