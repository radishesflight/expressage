<?php

namespace RadishesFlight\ExpressAge\Yto;

use RadishesFlight\ExpressAge\Ems\CurlTrait;

class Yto
{
    use Curl;
    public  function sign($dataString,$method,$key,$version='v1')
    {
        return base64_encode(pack('H*', md5($dataString.$method.$version.$key)));
    }

    public  function execute($url,$data)
    {
      return  $this->postCurl($url,json_encode($data));
    }
}