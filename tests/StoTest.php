<?php
require_once __DIR__ . '/../vendor/autoload.php';
$obj = new \RadishesFlight\ExpressAge\Sto\Sto('http://cloudinter-linkgatewaytest.sto.cn', 'CAKIYunuUvLDnLH', 'IJUjzk3qwE6azsGDENX24RBJcGdyjcy8', 'CAKIYunuUvLDnLH');
//创建快递订单
$data = [
    "orderNo" => "8885452262",
    "orderSource" => "****",
    "billType" => "00",
    "orderType" => "01",
    "sender" => [
        "name" => "测试名称",
        "tel" => "0558-45778586",
        "mobile" => "18775487548",
        "postCode" => "100001",
        "country" => "中国",
        "province" => "安徽",
        "city" => "合肥",
        "area" => "泸州",
        "town" => "测试镇",
        "address" => "XX街道XX小区XX楼888"
    ],
    "receiver" => [
        "name" => "测试名称",
        "tel" => "0556-45778586",
        "mobile" => "15575487548",
        "postCode" => "100001",
        "country" => "中国",
        "province" => "河北",
        "city" => "湖州",
        "area" => "江汉",
        "town" => "收件镇",
        "address" => "XX街道XX小区XX楼666",
        "safeNo" => "13466666632-0011"
    ],
    "cargo" => [
        "battery" => "10",
        "goodsType" => "大件",
        "goodsName" => "XX物",
        "goodsCount" => 10,
        "spaceX" => 10,
        "spaceY" => 10,
        "spaceZ" => 10,
        "weight" => 10,
        "goodsAmount" => "100",
        "cargoItemList" => [
            [
                "serialNumber" => "8451234",
                "referenceNumber" => "88838783634",
                "productId" => "001",
                "name" => "小商品",
                "qty" => 10,
                "unitPrice" => 1,
                "amount" => 10,
                "currency" => "美元",
                "weight" => 10,
                "remark" => "无"
            ]
        ]
    ],
    "customer" => [
        "siteCode" => "666666",
        "customerName" => "666666000001",
        "sitePwd" => "abc123",
        "monthCustomerCode" => "9000000"
    ],
//    "internationalAnnex" => [
//        "internationalProductType" => "01",
//        "customsDeclaration" => false,
//        "senderCountry" => "中国",
//        "receiverCountry" => "俄罗斯"
//    ],
//    "waybillNo" => null,
//    "assignAnnex" => [
//        "takeCompanyCode" => "862456565466",
//        "takeUserCode" => "9000000007"
//    ],
//    "codValue" => "2000",
//    "freightCollectValue" => "20",
//    "timelessType" => "01",
//    "productType" => "01",
//    "serviceTypeList" => [
//        "***"
//    ],
//    "extendFieldMap" => [
//        "mapValue" => "***"
//    ],
    "remark" => "无备注",
//    "expressDirection" => "01",
//    "createChannel" => "01",
//    "regionType" => "01",
//    "insuredAnnex" => [
//        "insuredValue" => "6.66",
//        "goodsValue" => "6.66"
//    ],
//    "expectValue" => "10",
//    "payModel" => "1"
];

$res =$obj->execute('/gateway/link.do',$data,'OMS_EXPRESS_ORDER_CREATE','sto_oms','sto_oms');
print_r($res);exit();