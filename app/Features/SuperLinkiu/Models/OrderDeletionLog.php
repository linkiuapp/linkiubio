<?php

namespace App\Features\SuperLinkiu\Models;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Models\User;

class OrderDeletionLog extends Model
{
    protected $fillable = [
        'order_id',
        'order_number',
        'store_id',
        'store_name',
        'customer_name',
        'total',
        'status',
        'order_data',
        'deleted_by',
        'reason',
    ];

    protected $casts = [
        'order_data' => 'array',
        'total' => 'decimal:2',
    ];

    public function deletedByUser()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}

