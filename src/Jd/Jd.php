<?php

namespace RadishesFlight\ExpressAge\Jd;

use Lop\LopOpensdkPhp\Filters\ErrorResponseFilter;
use Lop\LopOpensdkPhp\Filters\IsvFilter;
use Lop\LopOpensdkPhp\Options;
use Lop\LopOpensdkPhp\Support\DefaultClient;
use Lop\LopOpensdkPhp\Support\GenericRequest;

class Jd
{
    public $baseUri;
    public $appKey;
    public $appSecret;
    public $accessToken;
    public function __construct($baseUri, $appKey, $appSecret, $accessToken)
    {
        $this->baseUri = $baseUri;
        $this->appKey = $appKey;
        $this->appSecret = $appSecret;
        $this->accessToken = $accessToken;
        return $this;
    }
    public function execute($body,$path,$domain='ECAP',$method='POST')
    {
        $client = new DefaultClient( $this->baseUri);
        $isvFilter = new IsvFilter( $this->appKey, $this->appSecret, $this->accessToken);
        $errorResponseFilter = new ErrorResponseFilter();
        $request = new GenericRequest();
        $request->setDomain($domain); //对接方案的编码，应用订购对接方案后可在订阅记录查看
        $request->setPath($path); //api的path，可在API文档查看
        $request->setMethod($method); //只支持POST

        $body = json_encode($body);
        $request->setBody($body);

        // 为请求添加ISV模式过滤器，自动根据算法计算开放平台鉴权及签名信息
        $request->addFilter($isvFilter);
        // 为请求添加错误响应解析过滤器，如果不添加需要手动解析错误响应
        $request->addFilter($errorResponseFilter);

        $options = new Options();

        $options->setAlgorithm(Options::MD5_SALT);
        //$options->setAlgorithm(Options::HMAC_MD5);
        //$options->setAlgorithm(Options::HMAC_SHA1);
        //$options->setAlgorithm(Options::HMAC_SHA256);
        //$options->setAlgorithm(Options::HMAC_SHA512);
        $response = $client->execute($request, $options);
        return json_decode($response->getBody(), true);
    }
}