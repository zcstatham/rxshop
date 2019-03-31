<?php
/**
 * Created by PhpStorm.
 * MiniUser: EDZ
 * Date: 2018/12/7
 * Time: 19:19
 */

namespace app\api\controller\dev;

use service\sns\SnsService;
use think\facade\Log;

class Notify extends Base
{

    protected $beforeActionList = [
        'logInit' => ['except' => 'sns']
    ];

    /**
     * 第三方授权回调
     */
    public function sns()
    {
        $name = $this->params['platform'];
        $config = config('platform.' . $name);
        $snsInfo = SnsService::$name($config)->userinfo();
        $data = ['username' => 'sns', 'password' => $snsInfo];
        if (isset($this->params['inviter_code']) && $this->params['inviter_code'] != '') {
            $data['inviter_code'] = $this->params['inviter_code'];
        }
        return action('api/dev.index/login', $data);
    }

    /**
     * 支付回调
     * @return string
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function weixin()
    {
        $notify_data = $this->xmlToArray(file_get_contents("php://input"));
        Log::record($notify_data, 'info');
        if ($notify_data['result_code'] == 'SUCCESS' && $notify_data['return_code'] == 'SUCCESS') {
            $payment_info = model('PayInfo')->where('order_sn', $notify_data['out_trade_no'])->find();
            if (!$payment_info->isEmpty()) {
                $payment_info['pay_no'] = $notify_data['transaction_id'];
                if (!model('Orders')->checkOrderAndChangeStatus($payment_info)) {
                    return "ERROR";
                }
            }
        }
        return "SUCCESS";
    }


    /**
     * 支付宝回调
     * @return string
     */
    public function alipay()
    {

        Log::init(['type' => 'File', 'path' => WEB_PATH . '/runtime/Logs/notify/']);
        Log::write($_REQUEST, 'info');
        $data = $_REQUEST;

        if ($data['trade_status'] == 'TRADE_SUCCESS') {
            $out_trade_no = $data['out_trade_no'];
            $transaction_id = $data['trade_no'];
            $time = $data['gmt_payment'];

            if ($this->checkOrderAndChangeStatus(array('pay_sn' => $out_trade_no))) {
                //改变订单支付表信息
                model('Payment')->where('pay_sn', "=", $out_trade_no)->update(
                    array(
                        'pay_status' => 2,
                        'pay_type' => 'ALIPAY',
                        'pay_type_sn' => $transaction_id,
                        'pay_timestamp' => date('Y-m-d H:i:s', strtotime($time)),
                        'pay_type_info' => json_encode($data),
                    )
                );
            }
            //检测当前订单是不是团购订单，如果是团购订单，则需要创建团购团明细
            $payment_info = model('Payment')->_getOrderPaymentInfo(array('pay_sn=' . $out_trade_no));
            $order_id = explode(',', $payment_info['pay_orders']);
            $orderInfo = model('Orders')->where(array('order_id' => array('in', $order_id)))->select();
            if (isset($orderInfo[0]['order_type']) && (int)$orderInfo[0]['order_type'] == 2) {
                $sourceCode = trim($orderInfo[0]['source_code']);
                $uid = trim($orderInfo[0]['uid']);
                $this->_groupBuying($sourceCode, $payment_info['pay_orders'], $uid);
            }

        }

        return "SUCCESS";
    }

    private function xmlToArray($xml)
    {
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);

        $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);

        $val = json_decode(json_encode($xmlstring), true);

        return $val;

    }

    /**
     * 计算两日期之间的天数
     * @param $day1
     * @param $day2
     * @return float
     */
    protected function diffBetweenTwoDays($day1, $day2)
    {
        $second1 = strtotime($day1);
        $second2 = strtotime($day2);

        if ($second1 < $second2) {
            $tmp = $second2;
            $second2 = $second1;
            $second1 = $tmp;
        }
        return ($second1 - $second2) / 86400;
    }

    protected function logInit()
    {
        \think\facade\Log::init(['type' => 'File', 'path' => \think\facade\Env::get('runtime_path') . '/log/notify']);
    }
}
