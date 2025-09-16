<?php

namespace RadishesFlight\ExpressAge\Jt;

class Jt
{
    private $apiAccount;
    private $privateKey;
    private $customerCode;
    private $pwd;

    public function __construct($apiAccount, $privateKey, $customerCode, $pwd)
    {
        $this->apiAccount   = $apiAccount;
        $this->privateKey   = $privateKey;
        $this->customerCode = $customerCode;
        $this->pwd          = $pwd;
    }

    // Body 内 digest
    private function getContentDigest(): string
    {
        $str = strtoupper($this->customerCode . md5($this->pwd . 'jadada236t2')).$this->privateKey ;
        return base64_encode(pack('H*', strtoupper(md5($str))));
    }

    // Header digest
    private function getHeaderDigest(string $bizContent): string
    {
        $md5 = strtoupper(md5($bizContent . $this->privateKey));
        return base64_encode(pack("H*", $md5));
    }

    public function execute(array $orderData,string $url = '')
    {
        // 1. bizContent 内部 digest
        $orderData['customerCode'] = $this->customerCode;
        $orderData['digest']       = $this->getContentDigest();

        $bizContent = json_encode($orderData, JSON_UNESCAPED_UNICODE);

        // 2. header digest
        $headerDigest = $this->getHeaderDigest($bizContent);

        // 3. header 参数
        $headers = [
            "apiAccount: {$this->apiAccount}",
            "digest: {$headerDigest}",
            "timestamp: " . round(microtime(true) * 1000),
            "Content-Type: application/x-www-form-urlencoded; charset=UTF-8"
        ];

        // 4. body 参数
        $postFields = [
            "bizContent" => $bizContent
        ];

        // 5. 发送请求
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postFields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);
        return $response? json_decode($response, true):[];
    }
}