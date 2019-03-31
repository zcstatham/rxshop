<?php

namespace app\common\model;

use think\Model;

class Product extends Model
{
    //

    /**
     * 商品列表
     * @param array $data
     * @return array|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getProductList($data = array())
    {

        $map = [];
        $order = ['id'];
        $page = 0;
        $pageSize = 20;
        if (isset($data['order']) && $data['order']) {
            $order = array_merge($order, $data['order']);
        }
        if (isset($data['page']) && $data['page']) {
            $page = $data['page'];
        }
        if (isset($data['pageSize']) && $data['pageSize']) {
            $pageSize = $data['pageSize'];
        }
        if (isset($data['keyword']) && $data['keyword']) {
            $map[] = ['name|category_name', 'like', '%' . $data['keyword'] . '%'];
        }
        if (isset($data['category_id']) && $data['category_id']) {
            $map[] = ['category_id', '=', $data['category_id']];
        }
        if (isset($data['where']) && $data['where']) {
            $map = array_merge($map,$data['where']);
        }
        $field = array(
            'id' => 'goods_id',
            'name',
            'subtitle',
            'image',
            'price',
        );
        $limit = ($page * $pageSize) . ',' . $pageSize;
        return $this->field($field)->where($map)->order($order)->limit($limit)->select();
    }

    /**
     * 商品详情
     * @param $goods_id
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getProductDetail($goods_id)
    {
        $result = $this->field(array(
            'id' => 'goods_id',
            'name',
            'image',
            'subtitle',
            'banner',
            'detail',
            'price',
            'stock',
        ))->where(array(
            'id' => $goods_id
        ))->find()->toArray();
        return $result;
    }

}
