<?php

namespace App\Traits\Relations;
use App\Models\Branch;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongToTask
{
    public function task(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}
