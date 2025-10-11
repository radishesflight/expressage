<?php
require_once __DIR__ . '/../vendor/autoload.php';

use RadishesFlight\ExpressAge\Sf\Sf;


//下单
$data = [
    "merchantOrderNo" => "testV2_916293288736766666",
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
    "addedServices" => [
        [
            "name" => "IN144",
            "value1" => "1"
        ],
        [
            "name" => "IN142"
        ]
    ],
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
        "patientIdentityCardNo" => "450481197804234431",
        "patientName" => "陆堂诞",
        "patientPhone" => "18611888888",
        "prescriptionNos" => "666666",
        "takeMedicineIdentityName" => "处方号",
        "takeMedicineIdentityValue" => "1892731",
        "prescriptionList" => [
            [
                "no" => "1234231",
                "medicalDate" => "2023-05-31 12:00:00",
                "pharmacyName" => "测试药房二,测试药房三,测试药房一",
                "drugAmount" => 1,
                "drugs" => [
                    [
                        "name" => "党参123",
                        "specification" => "1",
                        "quantity" => 1,
                        "dosage" => "20ml",
                        "usage" => "口服",
                        "frequency" => "2次/日",
                        "totalAmount" => null,
                        "note" => "备注：第一个处方号"
                    ]
                ]
            ],
            [
                "no" => "5588233",
                "medicalDate" => "2023-06-01 12:00:00",
                "pharmacyName" => "测试药房一,测试药房二",
                "drugAmount" => 3,
                "drugs" => [
                    [
                        "name" => "氨溴特罗口服液",
                        "specification" => "120ml/瓶",
                        "quantity" => 1,
                        "dosage" => "20ml",
                        "usage" => "口服",
                        "frequency" => "3次/日",
                        "totalAmount" => "240ml",
                        "note" => "备注：第三个处方号"
                    ],
                    [
                        "name" => "党参",
                        "specification" => "1",
                        "quantity" => 2,
                        "dosage" => null,
                        "usage" => null,
                        "frequency" => null,
                        "totalAmount" => null,
                        "note" => "备注：第三个处方号"
                    ]
                ]
            ]
        ]
    ],
    "cargoDetail" => [
        "depositumInfo" => "手机",
        "depositumNo" => "1",
        "parcelWeighs" => "1.0"
    ],
    "service" => [
        "collectionMoney" => 10,
        "collectionNo" => "9999999999",
        "esignPictureType" => 13,
        "needReturnTrackingNumber" => "1",
        "packIndividuationMoney" => 100,
        "signFlag" => false
    ],
    "weiPaiParams" => [
        "orderTaskCode" => "asdhioas",
        "orderTaskFlag" => 0,
        "verifyCode" => "6666",
        "orderTaskType" => 0
    ],
    "extraInfoList" => [
        [
            "key" => "isNewExchange",
            "value" => "1"
        ]
    ]
];
$timestamp = Sf::getMillisecondTimestamp();
$headers = [
    'hospitalCode:YSYY001',
    'timestamp:' . $timestamp,
    'sign:' . Sf::sign(json_encode($data, JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES), 'AAAABBBBCCCCDDDD', $timestamp),
];
$res = Sf::curlPost('http://mrds-admin-ci.sit.sf-express.com:45478/api/open/api/v2/createOrder', $data, $headers);
print_r($res);exit();