<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Features\TenantAdmin\Models\Coupon;
use App\Shared\Models\Order;

class CouponUsageLog extends Model
{
    protected $fillable = [
        'coupon_id',
        'order_id',
        'session_id',
        'user_id',
        'discount_applied',
        'order_subtotal',
        'metadata'
    ];

    protected $casts = [
        'discount_applied' => 'decimal:2',
        'order_subtotal' => 'decimal:2',
        'metadata' => 'array'
    ];

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
