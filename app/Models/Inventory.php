<?php

namespace App\Models;

use App\Enums\TableEnum;
use App\Traits\DateFormat;
use App\Traits\Relations\BelongToGiftCard;
use App\Traits\Relations\HasCreatedByUpdatedBy;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use DateFormat,
        HasCreatedByUpdatedBy,
        BelongToGiftCard;

    protected $table = TableEnum::INVENTORIES;

    protected $fillable = [
        'gift_card_id',
        'redeem_code',
        'expire_date',
        'status',
        'created_by',
        'updated_by'
    ];
}
