<?php

namespace RadishesFlight\ExpressAge;

use Rtgm\sm\RtSm4;
use Exception;

class Ems extends AbstractExpress
{
    private $key;
    private $senderNo;
    private $authorization;

    public function __construct(string $host, string $senderNo, string $authorization, string $key)
    {
        parent::__construct($host);
        $this->senderNo = $senderNo;
        $this->authorization = $authorization;
        $this->key = utf8_encode($key);
    }

    public function signature(array $data): array
    {
        $this->validateRequiredData($data, ['logitcsInterface']);

        $data = $this->prepareBaseData($data);
        $logitcsInterface = utf8_encode($data['logitcsInterface']);
        
        $key = $this->key;
        $content = $logitcsInterface . $key;
        
        $sm4 = new RtSm4(base64_decode($key));
        $encryptData = $sm4->encrypt($content, 'sm4-ecb', "base64");
        $encryptData = hex2bin($encryptData);
        
        $data['logitcsInterface'] = '|$4|' . base64_encode($encryptData);
        
        return $data;
    }

    public function general(array $data): array
    {
        try {
            $signedData = $this->signature($data);
            $response = $this->curlPost($this->host, $signedData);
            return $this->formatResponse($response);
        } catch (Exception $e) {
            throw new Exception("EMS API Error: " . $e->getMessage());
        }
    }

    private function prepareBaseData(array $data): array
    {
        return array_merge($data, [
            'senderNo' => $this->senderNo,
            'authorization' => $this->authorization,
            'timeStamp' => date('Y-m-d H:i:s'),
        ]);
    }
}
