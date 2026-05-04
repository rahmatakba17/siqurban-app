<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'qr_code',
        'type',
        'sacrificer_name',
        'special_request',
        'region_id',
        'status',
        'received_by',
        'received_at',
        'scanned_by_user_id',
        'receiver_name',
        'receiver_notes',
    ];

    protected $casts = [
        'received_at' => 'datetime',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function scanHistories()
    {
        return $this->hasMany(ScanHistory::class);
    }

    public function scannedByUser()
    {
        return $this->belongsTo(User::class, 'scanned_by_user_id');
    }
}
