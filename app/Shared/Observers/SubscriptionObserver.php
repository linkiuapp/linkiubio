<?php

namespace App\Shared\Observers;

use App\Shared\Models\Subscription;
use Illuminate\Support\Facades\Log;

class SubscriptionObserver
{
    /**
     * Handle the Subscription "updating" event.
     * Sincronizar el estado de la tienda cuando cambie el status de la suscripción
     */
    public function updating(Subscription $subscription): void
    {
        // Solo sincronizar si cambió el status
        if (!$subscription->isDirty('status')) {
            return;
        }

        $oldStatus = $subscription->getOriginal('status');
        $newStatus = $subscription->status;
        $store = $subscription->store;

        if (!$store) {
            return;
        }

        // Sincronizar estado de la tienda basado en el nuevo status de la suscripción
        $this->syncStoreStatus($store, $oldStatus, $newStatus);
    }

    /**
     * Sincronizar el estado de la tienda con el estado de la suscripción
     */
    protected function syncStoreStatus($store, string $oldSubscriptionStatus, string $newSubscriptionStatus): void
    {
        // Si la suscripción se suspende, suspender la tienda (a menos que ya esté suspendida por otra razón)
        if ($newSubscriptionStatus === Subscription::STATUS_SUSPENDED && $oldSubscriptionStatus !== Subscription::STATUS_SUSPENDED) {
            // Solo actualizar si la tienda está activa y no tiene otra razón de suspensión manual
            if ($store->status === 'active' && empty($store->suspension_reason)) {
                $store->update([
                    'status' => 'suspended',
                    'suspension_reason' => 'subscription_suspended',
                    'suspended_at' => now(),
                ]);

                Log::info('🔄 SUBSCRIPTION OBSERVER: Tienda suspendida por cambio de status de suscripción', [
                    'store_id' => $store->id,
                    'store_name' => $store->name,
                    'old_subscription_status' => $oldSubscriptionStatus,
                    'new_subscription_status' => $newSubscriptionStatus,
                ]);
            }
        }

        // Si la suscripción se reactiva (de suspended a active), reactivar la tienda si estaba suspendida por la suscripción
        if ($newSubscriptionStatus === Subscription::STATUS_ACTIVE && $oldSubscriptionStatus === Subscription::STATUS_SUSPENDED) {
            if ($store->status === 'suspended' && $store->suspension_reason === 'subscription_suspended') {
                $store->update([
                    'status' => 'active',
                    'suspension_reason' => null,
                    'suspended_at' => null,
                    'suspended_invoice_id' => null,
                ]);

                Log::info('🔄 SUBSCRIPTION OBSERVER: Tienda reactivada por cambio de status de suscripción', [
                    'store_id' => $store->id,
                    'store_name' => $store->name,
                    'old_subscription_status' => $oldSubscriptionStatus,
                    'new_subscription_status' => $newSubscriptionStatus,
                ]);
            }
        }
    }
}
