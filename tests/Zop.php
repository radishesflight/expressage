<?php

use RadishesFlight\ExpressAge\Zop\ZopClient;
use RadishesFlight\ExpressAge\Zop\ZopProperties;
use RadishesFlight\ExpressAge\Zop\ZopRequest;

require_once __DIR__ . '/../vendor/autoload.php';

// ZopProperties类的构造方法接收两个参数，分别是companyid和key，都需要注册中通开放平台后到个人中心查看
$properties = new ZopProperties("d83404f574d8e2b8bfca6", "3e59beadef7d8595753f8c6c6a67dc4f");
$client = new ZopClient($properties);

$request = new ZopRequest();
$request->setUrl("https://japi-test.zto.com/zto.open.createOrder");
$request->setData('{"partnerType":"2","orderType":"1","partnerOrderCode":"商家自主定义","accountInfo":{"accountId":"test","type":1,"customerId":"GPG1576724269"},"senderInfo":{"senderName":"张三","senderPhone":"010-22226789","senderMobile":"13900000000","senderProvince":"上海","senderCity":"上海市","senderDistrict":"青浦区","senderAddress":"华志路"},"receiveInfo":{"receiverName":"Jone Star","receiverPhone":"021-87654321","receiverMobile":"13500000000","receiverProvince":"上海","receiverCity":"上海市","receiverDistrict":"闵行区","receiverAddress":"申贵路1500号"},"orderVasList":[{"vasType":"COD","vasAmount":100000}],"hallCode":"S2044","siteCode":"02100","siteName":"上海","summaryInfo":{"quantity":3,"price":30,"freight":20,"premium":10,"startTime":"2020-12-10 12:00:00","endTime":"2020-12-10 12:00:00"},"remark":"小吉下单","orderItems":[],"cabinet":{}}');

$a= $client->execute($request);
//打印
$data=json_decode($a,true);


$request->setUrl("https://japi-test.zto.com/zto.open.order.print");
$request->setData('{"printType":1,"billCode":'.$data['result']['billCode'].',"printLogo":false}');

$a1= $client->execute($request);
print_r($a1);
exit();
