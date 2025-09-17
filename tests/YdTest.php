<?php
require_once __DIR__ . '/../vendor/autoload.php';

$obj = new  \RadishesFlight\ExpressAge\Yunda\Yd( '999999', '04d4ad40eeec11e9bad2d962f53dda9d', '529951202001', 'Y4TQ3WBar9hpnw7As8xUZEReSuDdf2');
$obj->setServerUrl('https://u-openapi.yundasys.com/openapi-api/v1/accountOrder/createBmOrder');
$info = [
    "orders" => [
        [
            "collection_value" => 126.5,
            "cus_area1" => "订单号:2012121715001",
            "cus_area2" => "买家留言:请尽快发货",
            "isProtectPrivacy" => "",
            "items" => [
                [
                    "name" => "衣服",
                    "number" => 1,
                    "remark" => "袜子"
                ]
            ],
            "khddh" => "2012121715001",
            "node_id" => "350",
            "order_serial_no" => "20121217150021",
            "order_type" => "common",
            "platform_source" => "",
            "receiver" => [
                "address" => "上海市青浦区盈港东路 6679 号",
                "city" => "上海市",
                "company" => "",
                "county" => "青浦区",
                "mobile" => "17601206977",
                "name" => "李四",
                "province" => "上海市"
            ],
            "remark" => "",
            "sender" => [
                "address" => "上海市青浦区盈港东路 7766 号",
                "city" => "上海市",
                "company" => "",
                "county" => "青浦区",
                "mobile" => "17601206977",
                "name" => "张三",
                "province" => "上海市"
            ],
            "size" => "0.12,0.23,0.11",
            "special" => 0,
            "value" => 126.5,
            "weight" => 0,
            "multi_pack" => [
                "mulpck" => "",
                "total" => 0,
                "endmark" => 0
            ]
        ]
    ]
];

//$res = $obj->execute($info);


//面单
$bizContentArr = [
    'orders' => [
        [
            'mailno' => '313000000514213',
        ]
    ]
];
$obj->setServerUrl('https://u-openapi.yundasys.com/openapi/outer/v1/bm/getPdfInfo');
$res = $obj->execute($bizContentArr);


$pdfs= empty($res['data'])?[]:array_column($res['data'],null,'mailno');
foreach ($pdfs as $k=>$pdf){
    $pdfStream = $pdf['pdfInfo'];
    $pdfStream = base64_decode($pdfStream);
// 保存为本地文件
    $filePath = __DIR__ ."/$k". "output.pdf";
    file_put_contents($filePath, $pdfStream);
}

print_r($res);