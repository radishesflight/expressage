<?php
require_once __DIR__ . '/../vendor/autoload.php';

use RadishesFlight\ExpressAge\Sf\Sf;


//下单
$data = [
    "merchantOrderNo" => "testV2_916293".mt_rand(1000000000, 9999999999),
    "expressType" => "1",
    "payMethod" => 1,
    "monthlyCard" => "9999999999",
    "callFlag" => "0",
    "sendStartTime" => "2023-05-20 15:59:11",
    "statementValue" => 12311,
    "insureType" => "IN02",
    "retainFreshness" => false,
    "packagesNo" => 1,
    "productCode" => "CHINESE_HERBAL",
    "needConfirm" => 1,
    "needHandover" => 0,
    "remark" => "运单备注测试",
    "attach" => "运单附加数据测试",
    "contactInfo" => [
        "destAddress" => "光谷创业街66号海达创新广场12楼",
        "destCity" => "武汉市",
        "destDistrict" => "洪山区",
        "destName" => "姚文冲",
        "destPhone" => "18611838871",
        "destProvince" => "湖北省",
        "srcAddress" => "粤海街道创智大厦B座30楼",
        "srcCity" => "深圳市",
        "srcDistrict" => "南山区",
        "srcName" => "陆堂诞",
        "srcPhone" => "18611888888",
        "srcProvince" => "广东省"
    ],
    "patientInfo" => [
        "patientName" => "陆堂诞",
        "takeMedicineIdentityName" => "处方号",
        "takeMedicineIdentityValue" => "1892731",
    ],
    "cargoDetail" => [
        "depositumInfo" => "手机",
        "depositumNo" => "1",
        "parcelWeighs" => "1.0"
    ],
];
$timestamp = Sf::getMillisecondTimestamp();
$headers = [
    'hospitalCode:YSYY001',
    'timestamp:' . $timestamp,
    'sign:' . Sf::sign(json_encode($data, JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES), 'AAAABBBBCCCCDDDD', $timestamp),
];
//$res = Sf::curlPost('http://mrds-admin-ci.sit.sf-express.com:45478/api/open/api/v2/createOrder', $data, $headers);
//print_r($res);exit();


//物流
$data = [
    'trackingType' => 2,
    'trackingNumber' => "testV2_9162935368528456",//客户订单号
];

$timestamp = Sf::getMillisecondTimestamp();
$headers = [
    'hospitalCode:YSYY001',
    'timestamp:' . $timestamp,
    'sign:' . Sf::sign(json_encode($data, JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES), 'AAAABBBBCCCCDDDD', $timestamp),
];
//$res = Sf::curlPost('http://mrds-admin-ci.sit.sf-express.com:45478/api/open/api/v2/queryRoutes', $data, $headers);
//print_r($res);exit();

//面单
$data=[
    'merchantOrderNo'=>'testV2_9162935368528456',
    'maskFlag'=>0,
    'templateCode'=>'fm_76130_standard_inc-mrds-core',
    'isPrintLogo'=>false,
    'customTemplateCode'=>'fm_76130_standard_custom_10000306193_4',
    'customData'=>[
        'remarkFontSize'=>12
    ],
];
$timestamp = Sf::getMillisecondTimestamp();
$headers = [
    'hospitalCode:YSYY001',
    'timestamp:' . $timestamp,
    'sign:' . Sf::sign(json_encode($data, JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES), 'AAAABBBBCCCCDDDD', $timestamp),
];
$res = Sf::curlPost('http://mrds-admin-ci.sit.sf-express.com:45478/api/open/api/v2/printWaybills', $data, $headers);
print_r($res);exit();
