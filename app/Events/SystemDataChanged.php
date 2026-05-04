<?php

namespace App\Events;

use App\Models\AuditLog;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SystemDataChanged implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithBroadcasting, SerializesModels;

    public function __construct(public AuditLog $log)
    {
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('admin.notifications'),
            new PrivateChannel('panitia.notifications'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'system.data.changed';
    }

    public function broadcastWith(): array
    {
        $adminName = $this->log->user ? $this->log->user->name : 'Sistem';
        
        return [
            'message' => "{$adminName} melakukan perubahan data: {$this->log->description}",
            'type' => 'warning',
            'time' => now()->format('H:i'),
        ];
    }
}
