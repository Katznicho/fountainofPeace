<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'sponsor_id',
        'type',
        'payment_mode',
        'reference',
        'amount',
        'description',
        'phone_number',
        'status',
        'order_tracking_id',
        'OrderNotificationType',
        'user_id',
        'child_id'
    ];

    // transaction belongs to a sponsor
    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class);
    }
}
