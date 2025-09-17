<?php

namespace RadishesFlight\ExpressAge\Yunda;

class Yd
{
    private $serverUrl = "https://u-openapi.yundasys.com/openapi-api/v1/accountOrder/createBmOrder"; // 测试环境
    private $appKey = "999999";
    private $appSecret = "04d4ad40eeec11e9bad2d962f53dda9d";
    private $partner_id = "529951202001";
    private $secret = "Y4TQ3WBar9hpnw7As8xUZEReSuDdf2";

    public function __construct($appKey, $appSecret, $partner_id, $secret)
    {
        $this->appKey = $appKey;
        $this->appSecret = $appSecret;
        $this->partner_id = $partner_id;
        $this->secret = $secret;
    }

    public function setServerUrl($serverUrl)
    {
        $this->serverUrl = $serverUrl;
        return $this;
    }

    public function execute($info)
    {
        // 业务参数里增加 appid
        $info['appid'] = $this->appKey;
        $info['partner_id'] = $this->partner_id;
        $info['secret'] = $this->secret;

        // 1. 转 JSON
        $json_info = json_encode($info, JSON_UNESCAPED_UNICODE);

        // 2. 生成签名 = md5(请求体json + "_" + appSecret)
        $signStr = $json_info . "_" . $this->appSecret;
        $sign = md5($signStr);

        // 3. 设置请求头
        $header = [
            "app-key: " . $this->appKey,
            "sign: " . $sign,
            "req-time: " . time(),
            "Content-Type: application/json; charset=UTF-8"
        ];

        // 4. 发起请求
        return self::postJson($this->serverUrl, $json_info, $header);
    }

    private static function postJson($url, $data, $header, $timeout = 15)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $res = curl_exec($ch);
        if ($res === false) {
            throw new \Exception(curl_error($ch));
        }
        curl_close($ch);
        return $res ? json_decode($res, true) : [];
    }
}
