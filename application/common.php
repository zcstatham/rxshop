<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * +----------------------------------------------------------
 * 产生随机字串，可用来自动生成密码 默认长度6位 字母和数字混合
 * +----------------------------------------------------------
 * @param string $len 长度
 * @param string $type 字串类型
 * 0 字母 1 数字 其它 混合
 * @param string $addChars 额外字符
 * +----------------------------------------------------------
 * @return string
+----------------------------------------------------------
 */
function rand_string($len = 6, $type = '', $addChars = '')
{
    $str = '';
    switch ($type) {
        case 0:
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' . $addChars;
            break;
        case 1:
            $chars = str_repeat('0123456789', 3);
            break;
        case 2:
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' . $addChars;
            break;
        case 3:
            $chars = 'abcdefghijklmnopqrstuvwxyz' . $addChars;
            break;
        case 4:
            $chars = "们以我到他会作时要动国产的一是工就年阶义发成部民可出能方进在了不和有大这主中人上为来分生对于学下级地个用同行面说种过命度革而多子后自社加小机也经力线本电高量长党得实家定深法表着水理化争现所二起政三好十战无农使性前等反体合斗路图把结第里正新开论之物从当两些还天资事队批点育重其思与间内去因件日利相由压员气业代全组数果期导平各基或月毛然如应形想制心样干都向变关问比展那它最及外没看治提五解系林者米群头意只明四道马认次文通但条较克又公孔领军流入接席位情运器并飞原油放立题质指建区验活众很教决特此常石强极土少已根共直团统式转别造切九你取西持总料连任志观调七么山程百报更见必真保热委手改管处己将修支识病象几先老光专什六型具示复安带每东增则完风回南广劳轮科北打积车计给节做务被整联步类集号列温装即毫知轴研单色坚据速防史拉世设达尔场织历花受求传口断况采精金界品判参层止边清至万确究书术状厂须离再目海交权且儿青才证低越际八试规斯近注办布门铁需走议县兵固除般引齿千胜细影济白格效置推空配刀叶率述今选养德话查差半敌始片施响收华觉备名红续均药标记难存测士身紧液派准斤角降维板许破述技消底床田势端感往神便贺村构照容非搞亚磨族火段算适讲按值美态黄易彪服早班麦削信排台声该击素张密害侯草何树肥继右属市严径螺检左页抗苏显苦英快称坏移约巴材省黑武培著河帝仅针怎植京助升王眼她抓含苗副杂普谈围食射源例致酸旧却充足短划剂宣环落首尺波承粉践府鱼随考刻靠够满夫失包住促枝局菌杆周护岩师举曲春元超负砂封换太模贫减阳扬江析亩木言球朝医校古呢稻宋听唯输滑站另卫字鼓刚写刘微略范供阿块某功套友限项余倒卷创律雨让骨远帮初皮播优占死毒圈伟季训控激找叫云互跟裂粮粒母练塞钢顶策双留误础吸阻故寸盾晚丝女散焊功株亲院冷彻弹错散商视艺灭版烈零室轻血倍缺厘泵察绝富城冲喷壤简否柱李望盘磁雄似困巩益洲脱投送奴侧润盖挥距触星松送获兴独官混纪依未突架宽冬章湿偏纹吃执阀矿寨责熟稳夺硬价努翻奇甲预职评读背协损棉侵灰虽矛厚罗泥辟告卵箱掌氧恩爱停曾溶营终纲孟钱待尽俄缩沙退陈讨奋械载胞幼哪剥迫旋征槽倒握担仍呀鲜吧卡粗介钻逐弱脚怕盐末阴丰雾冠丙街莱贝辐肠付吉渗瑞惊顿挤秒悬姆烂森糖圣凹陶词迟蚕亿矩康遵牧遭幅园腔订香肉弟屋敏恢忘编印蜂急拿扩伤飞露核缘游振操央伍域甚迅辉异序免纸夜乡久隶缸夹念兰映沟乙吗儒杀汽磷艰晶插埃燃欢铁补咱芽永瓦倾阵碳演威附牙芽永瓦斜灌欧献顺猪洋腐请透司危括脉宜笑若尾束壮暴企菜穗楚汉愈绿拖牛份染既秋遍锻玉夏疗尖殖井费州访吹荣铜沿替滚客召旱悟刺脑措贯藏敢令隙炉壳硫煤迎铸粘探临薄旬善福纵择礼愿伏残雷延烟句纯渐耕跑泽慢栽鲁赤繁境潮横掉锥希池败船假亮谓托伙哲怀割摆贡呈劲财仪沉炼麻罪祖息车穿货销齐鼠抽画饲龙库守筑房歌寒喜哥洗蚀废纳腹乎录镜妇恶脂庄擦险赞钟摇典柄辩竹谷卖乱虚桥奥伯赶垂途额壁网截野遗静谋弄挂课镇妄盛耐援扎虑键归符庆聚绕摩忙舞遇索顾胶羊湖钉仁音迹碎伸灯避泛亡答勇频皇柳哈揭甘诺概宪浓岛袭谁洪谢炮浇斑讯懂灵蛋闭孩释乳巨徒私银伊景坦累匀霉杜乐勒隔弯绩招绍胡呼痛峰零柴簧午跳居尚丁秦稍追梁折耗碱殊岗挖氏刃剧堆赫荷胸衡勤膜篇登驻案刊秧缓凸役剪川雪链渔啦脸户洛孢勃盟买杨宗焦赛旗滤硅炭股坐蒸凝竟陷枪黎救冒暗洞犯筒您宋弧爆谬涂味津臂障褐陆啊健尊豆拔莫抵桑坡缝警挑污冰柬嘴啥饭塑寄赵喊垫丹渡耳刨虎笔稀昆浪萨茶滴浅拥穴覆伦娘吨浸袖珠雌妈紫戏塔锤震岁貌洁剖牢锋疑霸闪埔猛诉刷狠忽灾闹乔唐漏闻沈熔氯荒茎男凡抢像浆旁玻亦忠唱蒙予纷捕锁尤乘乌智淡允叛畜俘摸锈扫毕璃宝芯爷鉴秘净蒋钙肩腾枯抛轨堂拌爸循诱祝励肯酒绳穷塘燥泡袋朗喂铝软渠颗惯贸粪综墙趋彼届墨碍启逆卸航衣孙龄岭骗休借" . $addChars;
            break;
        case 5:
            $chars = 'ABCDEFGHIJKMNPQRSTUVWXYZ23456789' . $addChars;
            break;
        default:
            // 默认去掉了容易混淆的字符oOLl和数字01，要添加请使用addChars参数
            $chars = 'ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789' . $addChars;
            break;
    }
    if ($len > 10) {
        //位数过长重复字符串一定次数
        $chars = $type == 1 ? str_repeat($chars, $len) : str_repeat($chars, 5);
    }
    if ($type != 4) {
        $chars = str_shuffle($chars);
        $str = substr($chars, 0, $len);
    } else {
        // 中文随机字
        for ($i = 0; $i < $len; $i++) {
            $str .= msubstr($chars, floor(mt_rand(0, mb_strlen($chars, 'utf-8') - 1)), 1);
        }
    }
    return $str;
}

/**
 * 字符串截取，支持中文和其他编码
 * @static
 * @access public
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 * @return string
 */
function msubstr($str, $start = 0, $length, $charset = "utf-8", $suffix = true)
{
    if (function_exists("mb_substr")) {
        $slice = mb_substr($str, $start, $length, $charset);
    } elseif (function_exists('iconv_substr')) {
        $slice = iconv_substr($str, $start, $length, $charset);
        if (false === $slice) {
            $slice = '';
        }
    } else {
        $re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("", array_slice($match[0], $start, $length));
    }
    if (strlen($slice) == strlen($str)) {
        return $slice;
    } else {
        return $suffix ? $slice . '...' : $slice;
    }
}

/**
 * 获取社保配置信息
 * @return array|mixed
 * @throws \think\db\exception\DataNotFoundException
 * @throws \think\db\exception\ModelNotFoundException
 * @throws \think\exception\DbException
 */
function getSocialConf($type = null)
{
    $data = cache('sys_social_conf');
    /* 获取缓存数据 */
    if (empty($list)) {
        $configs = model('Config')
            ->field('name,title,value,extra,group1,group2')
            ->where('group1', 'in', ['social', 'fund', 'service', 'basic', 'other'])
            ->select();
        $data = array(
            'farmer' => array(
                'social' => [],
                'basic' => [],
                'fund' => [],
                'service' => []
            ),
            'town' => array(
                'social' => [],
                'basic' => [],
                'fund' => [],
                'service' => []
            ),
        );
        foreach ($configs as $config) {
            $data[$config['group2']][$config['group1']][$config['name']] = array(floatval($config['value']), floatval($config['extra']), $config['title']);
        }
        cache('sys_social_conf', $data);
    }
    if ($type) {
        $data = $data[$type];
    }
    return $data;
}

/**
 * 获取前100名折扣优惠名额
 * @return array
 * @throws \think\db\exception\DataNotFoundException
 * @throws \think\db\exception\ModelNotFoundException
 * @throws \think\exception\DbException
 */
function getTopDiscountsCoupon()
{
    $coupon = cache('sys_top_discounts_coupon');
    if (empty($coupon)) {
        $map = array(
            ['coupon_id', '=', 1],
            ['coupon_type', '=', 1],
            ['status', 'in', '1,2']
        );
        $coupon = model('Coupon')->field('id,money,number,period')->where('id', 1)->find()->toArray();
        $coupon['issue'] = model('CouponReceive')->where($map)->count();
        cache('sys_top_discounts_coupon', $coupon, 600);
    }
    return $coupon;
}


/**
 * 获取服务费缴费券
 * @param $uid
 * @param $type
 * @return array|mixed
 * @throws \think\db\exception\DataNotFoundException
 * @throws \think\db\exception\ModelNotFoundException
 * @throws \think\exception\DbException
 */
function getServiceDeductionCoupon($uid, $type)
{
    $data = cache('sys_service_deduction_coupon_' . $uid);
    if (empty($data)) {
        $map = array(
            ['uid', '=', $uid],
            ['coupon_id', '=', $type == 'single' ? 2 : 3],
            ['coupon_type', '=', 2],
            ['status', '=', '1']
        );
        $coupon = model('CouponReceive')->field('id')->where($map)->select()->toArray();
        $data = array(count($coupon), $coupon);
        cache('sys_service_deduction_coupon_' . $uid, $data, 600);
    }
    return $data;
}


/**
 * 计算费用明细
 * @param $param
 * @return array
 * @throws \think\db\exception\DataNotFoundException
 * @throws \think\db\exception\ModelNotFoundException
 * @throws \think\exception\DbException
 */
function getCalcBill($param)
{
    $conf = getSocialConf($param['social_type']);
    //缴费标准
    $socialBase = $param['social_basic'] == '0' ? $conf['basic'] : array(
        'pension' => [$param['social_basic']],
        'health' => [$param['social_basic']],
        'unemployment' => [$param['social_basic']],
        'injury' => [$param['social_basic']],
        'birth' => [$param['social_basic']],
    );
    //基本社保
    $bill = array(
        'social' => array(
            'pension' => [
                sprintf('%.2f',$socialBase['pension'][0] * ($conf['social']['pension'][0] + $conf['social']['pension'][1])),
                $conf['social']['pension'][2],
            ],
            'health' => [
                sprintf('%.2f',$socialBase['health'][0] * ($conf['social']['health'][0] + $conf['social']['health'][1])),
                $conf['social']['health'][2],
            ],
            'unemployment' => [
                sprintf('%.2f',$socialBase['unemployment'][0] * ($conf['social']['unemployment'][0] + $conf['social']['unemployment'][1])),
                $conf['social']['unemployment'][2],

            ],
            'injury' => [
                sprintf('%.2f',$socialBase['injury'][0] * ($conf['social']['injury'][0] + $conf['social']['injury'][1])),
                $conf['social']['injury'][2],
            ],
            'birth' => [
                sprintf('%.2f',$socialBase['birth'][0] * ($conf['social']['birth'][0] + $conf['social']['birth'][1])),
                $conf['social']['birth'][2],

            ],
            'largeMedic' => [
                sprintf('%.2f',$conf['social']['largeMedic'][0] + $conf['social']['largeMedic'][1]),
                $conf['social']['largeMedic'][2],
            ],
        ),
        'service_type' => $param['service_type'],
        'service' => sprintf('%.2f',$conf['service'][$param['service_type']][0]),
    );
    if (isset($conf['others'])) {
        $bill['others'] = sprintf('%.2f',$conf['others']);
    }


    //社保小计
    $bill['subtotal'] = 0;
    foreach ($bill['social'] as $i) {
        $bill['subtotal'] += $i[0];
    }
    $bill['subtotal'] = sprintf('%.2f',$bill['subtotal']);
    //是否缴纳公积金
    if (isset($param['fund_basic'])) {
        $fundBase = $param['fund_basic'] == '0' ? $conf['basic']['fund'][0] : $param['fund_basic'];
        $bill['fund'] = sprintf('%.2f',$fundBase * ($conf['fund']['fund'][0] + $conf['fund']['fund'][1]));
        $bill['service'] = sprintf('%.2f',$conf['service'][$param['service_type']][1]);
        $type = 'all';
    }

    //检查服务费抵扣余量，即是否已缴费
    if (($deduction = getServiceDeductionCoupon($param['uid'], $type))[0] > 0) {
        //服务费为0，记录待使用缴费券id
        $bill['service'] = 0;
        $bill['coupon'] = $deduction[1];
    } else {
        //检查半价优惠名额
        if (($discounts = getTopDiscountsCoupon())['issue'] < $discounts['number']) {
            //服务费折扣，记录折扣券信息
            $bill['service'] *= $discounts['money'];
            $bill['coupon'] = 0;
            $bill['discounts'] = true;
        }
    }
    $bill['service'] = sprintf('%.2f',$bill['service']);
    //总计
    $bill['total'] = sprintf('%.2f',(float)$bill['subtotal'] + (float)$bill['fund'] + (float)$bill['service']);
    return $bill;
}


function arrayToXml($arr, $root)
{
    $xml = '<' . $root . '>';
    foreach ($arr as $key => $val) {
        if (is_array($val)) {
            $xml .= '<' . $key . '>' . $this->arrayToXml($val, $root) . '</' . $key . '>';
        } else {
            $xml .= '<' . $key . '>' . $val . '</' . $key . '>';
        }
    }
    $xml .= '</' . $root . '>';
    $a = mb_detect_encoding($xml);
    return $xml;
}

function xmlToArray($xml)
{
    libxml_disable_entity_loader(true);
    $val = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    return $val;
}

/**
 * 下划线转驼峰
 * 思路:
 * step1.原字符串转小写,原字符串中的分隔符用空格替换,在字符串开头加上分隔符
 * step2.将字符串中每个单词的首字母转换为大写,再去空格,去字符串首部附加的分隔符.
 */
function camelize($uncamelized_words, $separator = '_')
{
    $uncamelized_words = $separator . str_replace($separator, " ", strtolower($uncamelized_words));
    return ltrim(str_replace(" ", "", ucwords($uncamelized_words)), $separator);
}

/**
 * 驼峰命名转下划线命名
 * 思路:
 * 小写和大写紧挨一起的地方,加上分隔符,然后全部转小写
 */
function uncamelize($camelCaps, $separator = '_')
{
    \think\facade\Log::record(preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $camelCaps));
    return strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $camelCaps));
}
