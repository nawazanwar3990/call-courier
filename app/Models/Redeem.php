<?php

namespace App\Models;

use App\Enums\TableEnum;
use App\Traits\DateFormat;
use App\Traits\Relations\BelongToGiftCard;
use App\Traits\Relations\BelongToInventory;
use App\Traits\Relations\HasCreatedByUpdatedBy;
use Illuminate\Database\Eloquent\Model;

class Redeem extends Model
{
    use BelongToInventory,
        BelongToGiftCard,
        HasCreatedByUpdatedBy,
        DateFormat;

    protected $table = TableEnum::REDEEMS;

    protected $fillable = [
        'gift_card_id',
        'inventory_id',
        'status',
        'created_by',
        'updated_by'
    ];
}
