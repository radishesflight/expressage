<?php
require_once __DIR__ . '/../vendor/autoload.php';

// ================= 使用示例 ==================
use RadishesFlight\ExpressAge\Jt\Jt;

$apiAccount = "178337126125932605";   // 测试账号
$privateKey = "0258d71b55fc45e3ad7a7f38bf4b201a";
$customerCode = "J0086474299";
$pwd = "H5CD3zE6";             // 示例口令

$jt = new Jt($apiAccount, $privateKey, $customerCode, $pwd);

$order = [
    "txlogisticId" => "TEST202509160001",
    "expressType" => "EZ",
    "orderType" => "1",
    "serviceType" => "01",
    "deliveryType" => "06",
    "payType" => "PP_PM",
    "sender" => [
        "name" => "小九",
        "mobile" => "15546168286",
        "countryCode" => "CHN",
        "prov" => "上海",
        "city" => "上海市",
        "area" => "青浦区",
        "address" => "庆丰三路28号"
    ],
    "receiver" => [
        "name" => "田丽",
        "mobile" => "13766245825",
        "countryCode" => "CHN",
        "prov" => "上海",
        "city" => "上海市",
        "area" => "嘉定区",
        "address" => "站前西路永利酒店斜对面童装店"
    ],
    "sendStartTime" => "2025-09-16 09:00:00",
    "sendEndTime" => "2025-09-16 18:00:00",
    "goodsType" => "bm000006",
    "weight" => "0.02",
    "items" => [
        ["itemName" => "衣帽鞋服", "number" => 1, "priceCurrency" => "RMB"]
    ]
];

//下单
$response = $jt->execute($order,'https://uat-openapi.jtexpress.com.cn/webopenplatformapi/api/order/addOrder?uuid=26ba9f2ba9164f969837e67cf758d8e1');
//print_r($response);

//面单
$bizContentArr = [
    "billCode"     => "UT0000755750756",
    "isPrivacyFlag"=> false
];
$response = $jt->execute($bizContentArr,'https://uat-openapi.jtexpress.com.cn/webopenplatformapi/api/order/printOrder?uuid=26ba9f2ba9164f969837e67cf758d8e1');

//print_r($response['data']['base64EncodeContent']);

$pdfStream = base64_decode($response['data']['base64EncodeContent']);
// 保存为本地文件
$filePath = __DIR__ . "/outputjt.pdf";
file_put_contents($filePath, $pdfStream);

echo "PDF 已保存: {$filePath}";
