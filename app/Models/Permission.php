<?php

namespace App\Models;

use App\Traits\Scopes\HasActiveScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    use HasActiveScope;

    protected $fillable = [
        'name',
        'label'
    ];
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

}
