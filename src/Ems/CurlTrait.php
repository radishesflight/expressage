<?php

namespace RadishesFlight\ExpressAge\Ems;

trait CurlTrait
{
    protected function curlPost(string $url, array $data, array $headers = ['Content-type:multipart/form-data']): string
    {
        $curl = curl_init();

        $headers = array_merge([
            "Accept: application/json",
        ], $headers);

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_FOLLOWLOCATION => true,
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error = curl_error($curl);
        curl_close($curl);
print_r($response);
        if ($error) {
            throw new \RuntimeException("cURL Error: {$error}");
        }

        if ($httpCode >= 400) {
            throw new \RuntimeException("HTTP Error: {$httpCode}");
        }

        return $response;
    }

    protected function curlGet(string $url, array $params = [], array $headers = [], int $timeout = 30): string
    {
        $ch = curl_init();

        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        $headers = array_merge([
            'Accept: application/json',
            'User-Agent: ExpressAge-PHP/1.0',
        ], $headers);

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => $timeout,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new \RuntimeException("cURL Error: {$error}");
        }

        if ($httpCode >= 400) {
            throw new \RuntimeException("HTTP Error: {$httpCode}");
        }

        return $response;
    }
}
