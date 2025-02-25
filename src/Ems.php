<?php

namespace RadishesFlight\ExpressAge;

use Rtgm\sm\RtSm4;

class Ems implements ExpressAgeInterFace
{
    use ExpressAgeCurlTrait;

    public $key;
    public $host;
    public $senderNo;
    public $authorization;

    public function __construct($host, $senderNo, $authorization, $key)
    {
        $this->host = $host;
        $this->senderNo = $senderNo;
        $this->authorization = $authorization;
        $this->key = utf8_encode($key);
        return $this;
    }

    private function processingData($data)
    {
        $data['senderNo'] = $this->senderNo;
        $data['authorization'] = $this->authorization;
        $data['timeStamp'] = date('Y-m-d H:i:s');
        return $data;
    }
    public function signature($data)
    {
        $data = $this->processingData($data);
        $logitcsInterface = utf8_encode($data['logitcsInterface']);
        $key = $this->key;
        $content = $logitcsInterface . $key;
        $sm4 = new RtSm4(base64_decode($key));
        $encryptData = $sm4->encrypt($content, 'sm4-ecb', "base64");
        $encryptData = hex2bin($encryptData);
        $data['logitcsInterface'] = '|$4|' . base64_encode($encryptData);
        return $data;
    }

    public function general($data)
    {
        $data = $this->signature($data);
        $json = $this->curlPost($this->host, $data);
        return $json ? json_decode($json, true) : [];
    }
}
