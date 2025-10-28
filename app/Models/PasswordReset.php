<?php

namespace App\Models;

use App\Enums\TableEnum;
use App\Traits\DateFormat;
use App\Traits\Relations\HasCreatedByUpdatedBy;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasCreatedByUpdatedBy, DateFormat;

    protected $table = TableEnum::PASSWORD_RESETS;
    protected $fillable = [
        'status',
        'created_by',
        'updated_by'
    ];
}
