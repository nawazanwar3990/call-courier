<?php

namespace App\Traits\Relations;
use App\Models\Branch;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongToBranch
{
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class,'branch_id');
    }
}
