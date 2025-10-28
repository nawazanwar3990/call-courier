<?php

namespace App\Traits\Relations;
use App\Models\GiftCard;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongToGiftCard
{
    public function giftCard(): BelongsTo
    {
        return $this->belongsTo(GiftCard::class,'gift_card_id');
    }
}
