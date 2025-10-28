<?php

namespace App\Models;

use App\Enums\TableEnum;
use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    protected $table = TableEnum::PERMISSION_ROLE;

    protected $fillable = [
        'role_id',
        'permission_id'
    ];
}
