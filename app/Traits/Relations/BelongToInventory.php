<?php

namespace App\Traits\Relations;
use App\Models\GiftCard;
use App\Models\Inventory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongToInventory
{
    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class,'inventory_id');
    }
}
