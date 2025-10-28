<?php

namespace App\Traits\Relations;
use App\Models\Type;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongToType
{
    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }
}
