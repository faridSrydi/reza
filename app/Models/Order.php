<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'address_id',
        'order_number',
        'payment_attempt',
        'midtrans_order_id',
        'snap_token',
        'total_amount',
        'currency',
        'status',
        'midtrans_transaction_status',
        'midtrans_payment_type',
        'midtrans_fraud_status',
        'paid_at',
        'cancelled_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getIsPayableAttribute(): bool
    {
        return in_array($this->status, ['pending', 'failed'], true);
    }

    public function getIsCancellableAttribute(): bool
    {
        return in_array($this->status, ['pending', 'failed'], true);
    }
}
