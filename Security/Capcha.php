<?php

declare(strict_types=1);

namespace Hutech\Security;

use Dotenv\Dotenv;

readonly class Capcha
{
    private string $siteKey;
    private string $secretKey;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        $this->siteKey = $_ENV['CAPCHA_SITE_KEY'];
        $this->secretKey = $_ENV['CAPCHA_SECRET_KEY'];
    }

    public function getSiteKey(): string
    {
        return $this->siteKey;
    }

    public function verify($response, $ip): bool
    {
        $url = "https://www.google.com/recaptcha/api/siteverify";

        $data = [
            "secret" => $this->secretKey,
            "response" => $response,
            "remoteip" => $ip
        ];

        $options = [
            "http" => [
                "header" => "Content-type: application/x-www-form-urlencoded\r\n",
                "method" => "POST",
                "content" => http_build_query($data)
            ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return json_decode($result)->success;
    }
}