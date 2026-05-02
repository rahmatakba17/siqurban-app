<?php

namespace App\Events;

use App\Models\Coupon;
use App\Models\ScanHistory;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CouponScanned
{
    use Dispatchable, InteractsWithBroadcasting, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public ScanHistory $scanHistory,
        public Coupon $coupon
    ) {
        $this->broadcastAs('coupon.scanned');
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('coupons'),
            new Channel('region.' . $this->coupon->region_id),
        ];
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'coupon_code' => $this->coupon->code,
            'coupon_id' => $this->coupon->id,
            'scanned_by' => $this->scanHistory->user->name,
            'region' => $this->coupon->region->name,
            'timestamp' => $this->scanHistory->scan_time,
        ];
    }
}
