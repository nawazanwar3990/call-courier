<?php

namespace App\Models;

use App\Enums\TableEnum;
use App\Traits\DateFormat;
use App\Traits\Relations\BelongToType;
use App\Traits\Relations\HasCreatedByUpdatedBy;
use App\Traits\Scopes\HasActiveScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class GiftCard extends Model implements HasMedia
{
    use HasActiveScope,
        SoftDeletes,
        InteractsWithMedia,
        DateFormat,
        HasCreatedByUpdatedBy,
        BelongToType;

    protected $table = TableEnum::GIFT_CARDS;
    protected $fillable = [
        'name',
        'type_id',
        'point_cost',
        'description',
        'terms',
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
