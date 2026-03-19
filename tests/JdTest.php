<?php
require_once __DIR__ . '/../vendor/autoload.php';

$data = [
    [
        "orderId" => "LG202204141438",
        "senderContact" => [
            "name" => "李先生",
            "mobile" => "15100170105",
            "fullAddress" => "上海市青浦区香花桥街道崧复路xxx号"
        ],
        "receiverContact" => [
            "name" => "陈先生",
            "mobile" => "15100170105",
            "fullAddress" => "江苏省无锡市江阴市新桥镇北欧印象xx栋xxx号"
        ],
        "orderOrigin" => 1,
        "customerCode" => "010K8969875", # 商家编码
        "productsReq" => [
            "productCode" => "LL-HD-M",
            "productAttrs" => [
                "warmLayer" => "usual"
            ],
            "addedProducts" => [
                [
                    "productCode" => "ed-a-0002",
                    "productAttrs" => [
                        "guaranteeMoney" => "100"
                    ]
                ],
                [
                    "productCode" => "ed-a-0010",
                    "productAttrs" => [
                        "reReceiveType" => "[\"signBill\",\"electronicStubForm\"]",
                        "reReceiveMode" => "[\"written\",\"electronic\"]",
                        "reReceiveSignType" => "[\"signName\",\"seal\",\"idNo\"]"
                    ]
                ]
            ]
        ],
        "settleType" => "3",
        "cargoes" => [
            [
                "name" => "文件",
                "quantity" => 1,
                "weight" => 1,
                "volume" => 10.2,
                "length" => 10.3,
                "width" => 10.5
            ]
        ],
        "remark" => "测试单，请勿接单",
        "CommonChannelInfo" => [
            "channelCode" => "0030001"
        ]
    ]
];
$a=(new \RadishesFlight\ExpressAge\Jd\Jd('https://api.jdl.com','0a6a5d1ef45541d998e99738dcbfa001','168087e648c2234559a833e02b6f7b78b','0498644f101c46d387053d9f251f235b'))->execute($data,'/ecap/v1/orders/create');
print_r($a);