<?php

declare(strict_types=1);

namespace Hutech\Security;

readonly class Capcha
{
    private string $siteKey;
    private string $secretKey;

    public function __construct()
    {
        $this->siteKey = "6Le6SugmAAAAAP4SdvUoSKLjf3bpfb0H9J-YV3Os";
        $this->secretKey = "6Le6SugmAAAAAHdlYnxRB6Nr5l5dphn5ZAuIy8bI";
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