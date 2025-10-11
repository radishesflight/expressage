<?php

namespace RadishesFlight\ExpressAge\Sf;

class Sf
{
    public static function sign($reqBody, $secretKey, $timestamp)
    {
        return hash('sha512', $reqBody . $secretKey . $timestamp);
    }

    public static function getMillisecondTimestamp()
    {
        list($micro, $seconds) = explode(' ', microtime());
        return (int)sprintf('%.0f', (floatval($micro) + floatval($seconds)) * 1000);
    }

    public static function curlPost($url, $data, $header = [])
    {
        if (empty($header)) {
            $header = ['Content-Type: application/json'];
        } else {
            $header = array_merge(['Content-Type: application/json'], $header);
        }

        // 将数据转换为JSON格式
        $jsonData = json_encode($data, JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES);
// 设置cURL选项
        $ch = curl_init($url);
        // 设置cURL选项
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// 执行cURL会话并获取返回结果
        $response = curl_exec($ch);

// 检查是否有错误发生
        if (curl_errno($ch)) {
        } else {
            // 处理返回的数据
        }
// 关闭cURL会话
        curl_close($ch);
        return json_decode($response, true);
    }
}