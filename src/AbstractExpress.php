<?php

namespace RadishesFlight\ExpressAge;

use Exception;

abstract class AbstractExpress implements ExpressAgeInterFace
{
    use ExpressAgeCurlTrait;

    protected $host;
    protected $config;

    public function __construct(string $host, array $config = [])
    {
        $this->host = $host;
        $this->config = $config;
    }

    protected function validateRequiredData(array $data, array $requiredFields): void
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

    protected function formatResponse(string $response): array
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

    abstract public function signature(array $data): array;
    abstract public function general(array $data): array;
}