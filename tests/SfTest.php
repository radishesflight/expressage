<?php
require_once __DIR__ . '/../vendor/autoload.php';


// 配置您的应用信息
$appId = 'JNQWJNXWC6JW';
$appKey = 'HswOK9IZdTvqMQAduYGaXJDZ7eq0ZOxM';

// 创建API实例（沙箱环境）
$sfApi = new \RadishesFlight\ExpressAge\Sf\Sf($appId, $appKey, true);

//https://open.sf-express.com/Api/ApiDetails?level3=393&interName=%E4%B8%8B%E8%AE%A2%E5%8D%95%E6%8E%A5%E5%8F%A3-EXP_RECE_CREATE_ORDER
// 构造订单数据
$orderData = [
    "cargoDetails" => [
        [
            "count" => 2.365,
            "unit" => "个",
            "weight" => 6.1,
            "amount" => 100.5111,
            "currency" => "HKD",
            "name" => "护肤品1",
            "sourceArea" => "CHN"
        ]
    ],
    "contactInfoList" => [
        [
            "address" => "广东省深圳市南山区软件产业基地11栋",
            "contact" => "小曾",
            "contactType" => 1,
            "country" => "CN",
            "postCode" => "580058",
            "tel" => "4006789888"
        ],
        [
            "address" => "广东省广州市白云区湖北大厦",
            "company" => "顺丰速运",
            "contact" => "小邱",
            "contactType" => 2,
            "country" => "CN",
            "postCode" => "580058",
            "tel" => "18688806057"
        ]
    ],
    "language" => "zh_CN",
    "orderId" => "OrderNum20200612223",
    "monthlyCard" => "7551234567" //月结号
];
//生成token
$res = $sfApi->getAccessToken();
// 调用下单接口
$result = $sfApi->execute('EXP_RECE_CREATE_ORDER', $orderData, $res['accessToken']);
print_r($result);
print_r(json_decode($result['apiResultData'], true));


//物流轨迹
$result = $sfApi->execute('EXP_RECE_SEARCH_ROUTES', [
    'trackingType' => 1,//1:根据顺丰运单号查询,trackingNumber将被当作顺丰运单号处理2:根据客户订单号查询,trackingNumber将被当作客户订单号处理
    'trackingNumber' => 'SF7444701404178',//查询号:trackingType=1,则此值为顺丰运单号如果trackingType=2,则此值为客户订单号
    'methodType' => 1,//路由查询类别:1:标准路由查询2:定制路由查询
], $res['accessToken']);


print_r($result);
print_r(json_decode($result['apiResultData'], true));
exit();
