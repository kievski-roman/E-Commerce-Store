<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public string $message,
        public array $user
    ) {}

    public function broadcastOn(): array
    {
        return [new PrivateChannel('chat')];
    }

    // Удобное короткое имя события для Echo
    public function broadcastAs(): string
    {
        return 'MessageSent';
    }

    // Что получить на фронте
    public function broadcastWith(): array
    {
        return [
            'message' => $this->message,
            'user'    => $this->user,
            'sent_at' => now()->toISOString(),
        ];
    }
}
