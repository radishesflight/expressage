<?php
require_once __DIR__ . '/../vendor/autoload.php';

$obj = new \RadishesFlight\ExpressAge\Yto\Yto();

$paramArray = [
    'logisticsNo' => 'DXqXQ0G135P',
    'senderName' => '测试1',
    'senderProvinceName' => '上海',
    'senderCityName' => '上海市',
    'senderCountyName' => '青浦区',
    'senderAddress' => '汇金路100号',
    'senderMobile' => '15900521555',
    'recipientName' => '测试',
    'recipientProvinceName' => '重庆',
    'recipientCityName' => '重庆市',
    'recipientCountyName' => '万州区',
    'recipientAddress' => '汇金路100好',
    'recipientMobile' => '021-59815121',
    'remark' => 'remark-test',
    'gotCode' => '123',
    'increments' => [
        [
            'type' => 4,
            'amount' => 888
        ]
    ],
    'goods' => [
        [
            'name' => 'mobile',
            'weight' => 5,
            'length' => 10,
            'width' => 20,
            'height' => 5,
            'price' => 100,
            'quantity' => 1
        ],
        [
            'name' => 'mobile1',
            'weight' => 1,
            'length' => 1,
            'width' => 1,
            'height' => 1,
            'price' => 1,
            'quantity' => 1
        ]
    ],
    'startTime' => '2025-10-16 17:06:03',
    'endTime' => '2025-10-16 17:06:03',
    'cstOrderNo' => 'csorderno',
    'weight' => 5,
    'productCode' => 'PK'
];
$sign = $obj->sign(json_encode($paramArray, JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES), 'privacy_create_adapter', 'u2Z1F7Fh');

//毫秒时间戳
$data = [
    //毫秒时间戳
    'timestamp' => round(microtime(true) * 1000),
    'param' => json_encode($paramArray, JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES),
    'sign' => $sign,
    'format' => 'JSON',
];
$res = $obj->execute("https://openuat.yto56test.com:6443/open/privacy_create_adapter/v1/7hAVQz/K9991024989", $data);
print_r($res);exit();


//物流查询
$paramArray =[
    'Number' => 'YT2819014489339',
];
$sign = $obj->sign(json_encode($paramArray, JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES), 'track_query_adapter', '123456');
//毫秒时间戳
$data = [
    //毫秒时间戳
    'timestamp' => round(microtime(true) * 1000),
    'param' => json_encode($paramArray, JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES),
    'sign' => $sign,
    'format' => 'JSON',
];

$res = $obj->execute("https://openuat.yto56test.com:6443/open/track_query_adapter/v1/JRe9WQ/TEST", $data);
print_r($res);exit();


//面单
$paramArray =[
    'waybillNo' => 'YT2819014287715',
];
$sign = $obj->sign(json_encode($paramArray, JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES), 'waybill_print_adapter', 'u2Z1F7Fh');

//毫秒时间戳
$data = [
    //毫秒时间戳
    'timestamp' => round(microtime(true) * 1000),
    'param' => json_encode($paramArray, JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES),
    'sign' => $sign,
    'format' => 'JSON',
];
$res = $obj->execute("https://openuat.yto56test.com:6443/open/waybill_print_adapter/v1/7hAVQz/K9991024989", $data);


$pdfStream = $res['data']['pdfBase64'];
$pdfStream = base64_decode($pdfStream);
// 保存为本地文件
$filePath = __DIR__ . "/output.pdf";
file_put_contents($filePath, $pdfStream);

echo "PDF 已保存: {$filePath}";





//取消
$paramArray =[
    'logisticsNo' => 'DXqXQ0G135P',
    'cancelDesc'=>'测试'
];
$sign = $obj->sign(json_encode($paramArray, JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES), 'korder_cancel_adapter', 'u2Z1F7Fh');
//毫秒时间戳
$data = [
    //毫秒时间戳
    'timestamp' => round(microtime(true) * 1000),
    'param' => json_encode($paramArray, JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES),
    'sign' => $sign,
    'format' => 'JSON',
];

$res = $obj->execute("https://openuat.yto56test.com:6443/open/korder_cancel_adapter/v1/JRe9WQ/K9991024989", $data);
print_r($res);exit();


