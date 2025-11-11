<?php

namespace App\Models;

use App\Enums\RoleEnum;
use App\Traits\Relations\BelongToBranch;
use App\Traits\Relations\HasCreatedByUpdatedBy;
use App\Traits\Relations\HasDeletedBy;
use App\Traits\Scopes\HasActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    use SoftDeletes,
        HasFactory,
        Notifiable,
        HasCreatedByUpdatedBy,
        HasDeletedBy,
        HasActiveScope,
        CausesActivity,
        BelongToBranch,
        InteractsWithMedia;

    protected $fillable = [
        'username',
        'active',
        'password',
        'branch_id',
        'created_by',
        'updated_by',
        'normal_password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function getUsernameAttribute($value): string
    {
        return str_replace('_', ' ', $value);
    }

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
            'privacy_policy'=>'boolean',
            'email_verified_at' => 'datetime',
            'password' => 'hashed'
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('picture')
            ->useFallbackUrl(asset('assets/img/user-picture.jpg'))
            ->useFallbackPath(public_path('assets/img/user-picture.jpg'))
            ->singleFile();

        $this->addMediaCollection('signature')
            ->singleFile();
    }
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)
            ->using(RoleUser::class)
            ->withTimestamps();
    }

    public function hasRole($role): bool
    {
        if (is_string($role)) {
            return $this->roles->contains('label', $role);
        }
        return !!$role->intersect($this->roles);
    }

    public function ability($permission = null): bool
    {
        return !is_null($permission) && RoleEnum::checkPermission($this, $permission);
    }

    public function getRoleId()
    {
        return $this->roles[0]->id;
    }

    public function receivesBroadcastNotificationsOn(): string
    {
        return 'reward-notifications-channel.'.$this->id;
    }
}
