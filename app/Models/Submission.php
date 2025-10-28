<?php

namespace App\Models;

use App\Enums\TableEnum;
use App\Traits\DateFormat;
use App\Traits\Relations\BelongToTask;
use App\Traits\Relations\HasCreatedByUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Submission extends Model implements HasMedia
{
    protected $table = TableEnum::SUBMISSIONS;
    use SoftDeletes,
        InteractsWithMedia,
        BelongToTask,
        DateFormat,
        HasCreatedByUpdatedBy;

    protected $fillable = [
        'task_id',
        'status',
        'created_by',
        'updated_by'
    ];
}
