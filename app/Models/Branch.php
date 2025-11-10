<?php

namespace App\Models;

use App\Enums\TableEnum;
use App\Traits\Relations\BelongToUser;
use App\Traits\Relations\HasCreatedByUpdatedBy;
use App\Traits\Scopes\HasActiveScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Branch extends Model implements HasMedia
{
    use HasActiveScope,
        SoftDeletes,
        InteractsWithMedia,
        BelongToUser,
        HasCreatedByUpdatedBy;
    protected  $table = TableEnum::BRANCHES;
    protected $fillable = [
        'name',
        'active',
        'created_by',
        'updated_by'
    ];
    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('picture')
            ->useFallbackUrl(asset('assets/img/default.png'))
            ->useFallbackPath(public_path('assets/img/default.png'))
            ->singleFile();
    }
}
