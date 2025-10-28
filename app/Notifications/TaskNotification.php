<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class TaskNotification extends Notification
{
    public function __construct(
        public string $heading,
        public string $description,
    )
    {
    }

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'heading' => $this->heading,
            'description'=>$this->description,
            'created_at' => now()->format('d-M-Y h:i A'),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'heading' => $this->heading,
            'description'=>$this->description,
            'created_at' => now()->format('d-M-Y h:i A'),
        ]);
    }

    public function toArray($notifiable): array
    {
        return [
            'heading' => $this->heading,
            'description'=>$this->description,
            'created_at' => now()->format('d-M-Y h:i A'),
        ];
    }

    public function broadcastType(): string
    {
        return 'task.submitted';
    }
}
