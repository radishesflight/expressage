<?php

namespace RadishesFlight\ExpressAge;

use Exception;

class StoExpress extends AbstractExpress
{
    private $secret;
    private $fromAppKey;
    private $fromCode;

    public function __construct(string $host, string $fromAppKey, string $fromCode, string $secret)
    {
        parent::__construct($host);
        $this->secret = $secret;
        $this->fromAppKey = $fromAppKey;
        $this->fromCode = $fromCode;
    }

    public function signature(array $data): array
    {
        $this->validateRequiredData($data, ['content']);

        return [
            'api_name' => $data['api_name'] ?? '',
            'content' => $data['content'],
            'data_digest' => base64_encode(md5($data['content'] . $this->secret, true)),
        ];
    }

    public function general(array $data): array
    {
        try {
            $signedData = $this->signature($data);
            $this->validateRequiredData($data, ['to_appkey', 'to_code']);

            $params = array_merge($signedData, [
                'from_appkey' => $this->fromAppKey,
                'from_code' => $this->fromCode,
                'to_appkey' => $data['to_appkey'],
                'to_code' => $data['to_code'],
            ]);

            $response = $this->curlGet($this->host, $params);
            return $this->formatResponse($response);
        } catch (Exception $e) {
            throw new Exception("STO Express API Error: " . $e->getMessage());
        }
    }
}
