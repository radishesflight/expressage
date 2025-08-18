<?php
require_once __DIR__ . '/../vendor/autoload.php';
$ems = new \RadishesFlight\ExpressAge\Ems('https://api.ems.com.cn/amp-prod-api/f/amp/api/test',
    '1100172843670', 'UkoD7gaL7RzI8MDf', 'QkJ3U01vdFpIa3o3a2o0eQ==');
$data=[
    [
        'ecommerceUserId'=> mt_rand(1000000000000000,9999999999999999),//电商客户标识 这个字段可以填一个<50 位随机数
        'logisticsOrderNo'=>mt_rand(1000000000000000,9999999999999999),//物流订单号(客户内部订单号)
        'createdTime'=>date('Y-m-d H:i:s'),//创建时间
        'contentsAttribute'=>1, // 1：文件 3、物品
        'bizProductNo'=>'2', //1：特快专递2：快递包裹3：特快到付9：国内即日10：电商标快11：国内标快
        'sender'=>[
            'name'=>'张三',// 发货人姓名
            'mobile'=>'134586455011',// 发货人手机'
            'phone'=>'028-09992992',// 发货人电话
            'prov'=>'广东省', // 发货人省
            'city'=>'深圳市',// 发货人市
            'county'=>'宝安区',// 发货人县
            'address'=>'深圳宝安大道',// 发货人地址
        ],// 发货人信息
        'receiver'=>[
            'name'=>'张三',// 收货人姓名
            'mobile'=>'134586455011',// 收货人手机
            'phone'=>'028-09992992',// 收货人电话
            'prov'=>'广东省', // 收货人省
            'city'=>'深圳市',// 收货人市
            'county'=>'宝安区',// 收货人县
            'address'=>'深圳宝安大道',// 收货人地址
        ],// 收货人信息
        'cargos'=>[
            [
                'cargoName'=>'测试商品',// 商品名称
                'cargoQuantity'=>1,// 商品数量
            ]
        ],
    ]
];
$jsonString = json_encode($data);
//下单
$a = $ems->general([
    'logitcsInterface' => $jsonString,
    'apiCode' => '020003',
]);
echo '<pre>';
//打印
print_r($a);
$waybillNo = isset($a['retBody'])?json_decode($a['retBody'],true)['waybillNo']:'';
//面单查询
$jsonString = json_encode([
    'waybillNo' => $waybillNo,
    'type' => '129', //面单类型 129：总部模板 76129 149：总部模板 76149   179 ： 总 部 模 板100179
    'getURL' => '1', //提供获取面单地址，可通过地址下载 pdf面单
    'isReturn' => '0'//正反面单类型，1-获取反向面单，0 或不传为获取正向面单
]);
$a=$ems->general([
    'logitcsInterface' => $jsonString,
    'apiCode' => '010004',
]);
print_r($a);
exit();
