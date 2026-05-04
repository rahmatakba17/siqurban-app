<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScanHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'coupon_id',
        'user_id',
        'scan_time',
        'notes',
        'ip_address',
        'device_info',
        'scan_method',
        'status_result',
    ];

    protected $casts = [
        'scan_time' => 'datetime',
    ];

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
