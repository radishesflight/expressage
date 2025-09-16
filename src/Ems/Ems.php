<?php

namespace RadishesFlight\ExpressAge\Ems;

use Exception;
use Rtgm\sm\RtSm4;

class Ems
{
    use CurlTrait;

    private $key;
    private $senderNo;
    private $authorization;
    private $host;

    public function __construct(string $host, string $senderNo, string $authorization, string $key)
    {
        $this->host = $host;
        $this->senderNo = $senderNo;
        $this->authorization = $authorization;
        $this->key = utf8_encode($key);
    }

    private function validateRequiredData(array $data, array $requiredFields): void
    {
        $missing = [];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                $missing[] = $field;
            }
        }

        if (!empty($missing)) {
            throw new Exception("Missing required fields: " . implode(', ', $missing));
        }
    }

    private function signature(array $data): array
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

    private function formatResponse(string $response): array
    {
        if (empty($response)) {
            throw new Exception("Empty response from API");
        }

        $decoded = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Invalid JSON response: " . json_last_error_msg());
        }

        return $decoded;
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
