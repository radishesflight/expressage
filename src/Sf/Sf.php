<?php

namespace RadishesFlight\ExpressAge\Sf;

use Exception;

class Sf
{
    private $appId;     // 应用ID
    private $appKey;    // 应用密钥
    private $apiUrl;    // API接口地址

    public function __construct($appId, $appKey, $sandbox = true)
    {
        $this->appId = $appId;
        $this->appKey = $appKey;
        // 沙箱环境和生产环境的接口地址不同
        $this->apiUrl = $sandbox
            ? 'https://sfapi-sbox.sf-express.com/'
            : 'https://sfapi.sf-express.com/';
    }

    /**
     * 执行请求
     */
    public function execute($serviceCode,$orderData, $accessToken,$url='std/service')
    {
        $time = time() * 1000;
        // 构造请求参数
        $requestParams = [
            'partnerID' => $this->appId,
            'requestID' => uniqid(), // 请求唯一标识
            'serviceCode' => $serviceCode,
            'timestamp' => $time, //毫秒时间戳
            'msgData' => json_encode($orderData, JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES),
            'accessToken' => $accessToken,
        ];
        // 发送请求
        return $this->sendRequest($url, $requestParams);
    }

    public function getAccessToken()
    {
        return $this->sendRequest('oauth2/accessToken', ['partnerID' => $this->appId, 'secret' => $this->appKey, 'grantType' => 'password']);
    }

    /**
     * 生成签名
     */
    private function generateSign($params)
    {
        $msgData = $params['msgData'];
        $timestamp = $params['timestamp'];
        $checkWord = $this->appKey;
        // 1. 拼接签名原文（顺序非常重要）
        $toVerifyText = $msgData . $timestamp . $checkWord;

        // 2. MD5（得到二进制结果）
        $md5Binary = md5($toVerifyText, true);

        // 3. Base64 编码
        return base64_encode($md5Binary);
    }

    /**
     * 发送HTTP请求
     */
    private function sendRequest($url, $params)
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $this->apiUrl . $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/x-www-form-urlencoded;charset=UTF-8'
            ]
        ]);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new Exception('CURL Error: ' . $error);
        }
        return json_decode($response, true);
    }
}