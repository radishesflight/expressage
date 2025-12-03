<?php

namespace RadishesFlight\ExpressAge\Sto;

class Sto
{

    public $host = 'http://cloudinter-linkgatewaytest.sto.cn';
    public $appKey = 'CAKIYunuUvLDnLH';
    public $secretKey = 'IJUjzk3qwE6azsGDENX24RBJcGdyjcy8';
    public $code = 'CAKIYunuUvLDnLH';

    public function __construct($host, $appKey, $secretKey, $code)
    {
        $this->host = $host;
        $this->appKey = $appKey;
        $this->secretKey = $secretKey;
        $this->code = $code;
    }

    public function execute(string $url, array $data, $apiName,$to_appkey, $to_code)
    {

        $url = $this->host . $url;
        $content = json_encode($data);

        $param = [
            'content' => $content,
            'data_digest' => base64_encode(md5($content . $this->secretKey, true)),
            'api_name' => $apiName,
            'from_appkey' => $this->appKey,
            'from_code' => $this->code,
            'to_appkey' => $to_appkey,
            'to_code' => $to_code,
        ];
        return self::curlPost($url, $param);
    }

    public static function curlPost($url, $data, $header = ['Content-type:multipart/form-data'])
    {
        $curl = curl_init();
        $header = array_merge([
            "Accept: */*",
        ], $header);
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => $header,
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return $err;
        } else {
            return $response;
        }
    }

}