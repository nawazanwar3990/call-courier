<?php

namespace App\Models;

use App\Enums\TableEnum;
use App\Traits\Relations\HasCreatedByUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes, HasCreatedByUpdatedBy;

    protected $fillable = [
        'name',
        'label',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, TableEnum::ROLE_USER)->withTimestamps();
    }
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, TableEnum::PERMISSION_ROLE)->withTimestamps();
    }
}
