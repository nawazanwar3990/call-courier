<?php

namespace App\Traits\Relations;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongToUser
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
