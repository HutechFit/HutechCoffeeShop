<?php

namespace Hutech\Controllers\Api;

abstract class ApiBaseController
{
    protected function validMethod($method): void
    {
        if($_SERVER['REQUEST_METHOD'] !== $method) {
            http_response_code(405);
            echo json_encode(
                ['error' => 'Phương thức không hợp lệ'],
                JSON_UNESCAPED_UNICODE
            );
            exit;
        }
    }
}