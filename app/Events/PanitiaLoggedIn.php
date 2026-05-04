<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PanitiaLoggedIn implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithBroadcasting, SerializesModels;

    public function __construct(public User $user)
    {
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('admin.notifications'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'panitia.logged.in';
    }

    public function broadcastWith(): array
    {
        return [
            'message' => "Panitia {$this->user->name} baru saja login.",
            'type' => 'info',
            'time' => now()->format('H:i'),
        ];
    }
}
