<?php

namespace App\Shared\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKeyRecoveryRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'requested_by',
        'status',
        'approved_by',
        'reason',
        'resolved_at'
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relaciones
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function requestedByUser()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approvedByUser()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Métodos helper
    public function approve($superAdminId)
    {
        $this->update([
            'status' => 'approved',
            'approved_by' => $superAdminId,
            'resolved_at' => now()
        ]);

        // Desactivar la clave maestra de la tienda
        $this->store->removeMasterKey();
    }

    public function reject($superAdminId, $reason = null)
    {
        $this->update([
            'status' => 'rejected',
            'approved_by' => $superAdminId,
            'reason' => $reason,
            'resolved_at' => now()
        ]);
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }
}

