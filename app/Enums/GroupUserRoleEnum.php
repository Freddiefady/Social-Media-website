<?php

declare(strict_types=1);

namespace App\Enums;

enum GroupUserRoleEnum: string
{
    case ADMIN = 'admin';

    case USER = 'user';
}
