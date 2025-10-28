<?php

namespace App\Models;

use App\Enums\TableEnum;
use App\Traits\DateFormat;
use App\Traits\Relations\BelongToGiftCard;
use App\Traits\Relations\BelongToTask;
use App\Traits\Relations\HasCreatedByUpdatedBy;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use BelongToGiftCard,
        BelongToTask,
        HasCreatedByUpdatedBy,
        DateFormat;

    protected $table = TableEnum::HISTORIES;
    protected $fillable = [
        'task_id',
        'gift_card_id',
        'coins',
        'created_by',
        'updated_by'
    ];
}
