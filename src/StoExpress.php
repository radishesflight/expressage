<?php

namespace RadishesFlight\ExpressAge;

class StoExpress implements ExpressAgeInterFace
{
    use ExpressAgeCurlTrait;

    public $secret;
    public $host;
    public $fromAppKey;
    public $fromCode;

    public function __construct($host, $fromAppKey, $fromCode, $secret)
    {
        $this->host = $host;
        $this->secret = $secret;
        $this->fromAppKey = $fromAppKey;
        $this->fromCode = $fromCode;
        return $this;
    }

    public function signature($data)
    {
        $data['data_digest'] = base64_encode(md5($data['content'] . $this->secret, true));
        return $data;
    }

    public function general($data)
    {
        $data = $this->signature($data);

        $param = [
            'api_name' => $data['api_name'],
            'content' => $data['content'],
            'data_digest' => $data['data_digest'],
            'from_appkey' => $this->fromAppKey,
            'from_code' => $this->fromCode,
            'to_appkey' => $data['to_appkey'],
            'to_code' => $data['to_code'],
        ];

        return $this->curlGet($this->host, $param);
    }
}
