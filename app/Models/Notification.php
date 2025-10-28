<?php

namespace App\Models;
use App\Enums\TableEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $table = TableEnum::NOTIFICATIONS;
    protected $casts = [
        'data' => 'array',
    ];
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'notification_type',
        'notifiable_type',
        'notifiable_id',
        'type',
        'data',
        'read_at',
    ];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
