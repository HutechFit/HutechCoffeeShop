<?php

declare(strict_types=1);

namespace Hutech\Enum;

enum LoginProvider: string
{
    case LOCAL = 'Đăng nhập bằng tài khoản';
    case GOOGLE = 'Đăng nhập bằng Google';
    case FACEBOOK = 'Đăng nhập bằng Facebook';
    case GITHUB = 'Đăng nhập bằng Github';
}
