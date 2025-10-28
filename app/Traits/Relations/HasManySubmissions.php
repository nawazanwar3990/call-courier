<?php

namespace App\Traits\Relations;
use App\Models\Submission;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManySubmissions
{
    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }
    public function userSubmissions(): HasMany
    {
        return $this->submissions()->where('created_by', auth()->id());
    }
}
