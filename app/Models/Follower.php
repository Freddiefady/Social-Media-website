<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\FollowerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Follower extends Model
{
    /** @use HasFactory<FollowerFactory> */
    use HasFactory;
    //
}
