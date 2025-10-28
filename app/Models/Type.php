<?php

namespace App\Models;

use App\Enums\TableEnum;
use App\Traits\DateFormat;
use App\Traits\Relations\HasCreatedByUpdatedBy;
use App\Traits\Scopes\HasActiveScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model
{
    use HasCreatedByUpdatedBy,
        DateFormat,
        SoftDeletes,
        HasActiveScope;

    protected $table = TableEnum::TYPES;
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
}
