<?php

namespace App\Enums;

enum GroupUserStatusEnum: string
{
    case APPROVED = 'approved';

    case PENDING = 'pending';

    case REJECTED = 'rejected';
}
