<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Shared\Models\Store;
use App\Shared\Models\Subscription;
use Illuminate\Support\Facades\Log;

class SyncStoreSubscriptionStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'stores:sync-subscription-status 
                            {--dry-run : Run without making changes}
                            {--store= : Sync specific store by ID or slug}';

    /**
     * The console command description.
     */
    protected $description = 'Sincronizar estados entre tiendas y sus suscripciones';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $isDryRun = $this->option('dry-run');
        $storeFilter = $this->option('store');

        $this->info('🔄 Sincronizando estados de tiendas y suscripciones...');

        if ($isDryRun) {
            $this->warn('⚠️  MODO DRY-RUN: No se realizarán cambios reales');
        }

        // Obtener tiendas con suscripciones
        $query = Store::with('subscription')
            ->whereHas('subscription');

        if ($storeFilter) {
            $query->where(function($q) use ($storeFilter) {
                $q->where('id', $storeFilter)
                  ->orWhere('slug', $storeFilter);
            });
        }

        $stores = $query->get();

        if ($stores->isEmpty()) {
            $this->warn('No se encontraron tiendas con suscripciones');
            return 0;
        }

        $this->info("📊 Analizando {$stores->count()} tienda(s) con suscripción(es)...\n");

        $stats = [
            'already_synced' => 0,
            'synced_from_subscription' => 0,
            'synced_from_store' => 0,
            'skipped_manual' => 0,
            'errors' => 0,
        ];

        foreach ($stores as $store) {
            $subscription = $store->subscription;
            
            if (!$subscription) {
                continue;
            }

            $storeStatus = $store->status;
            $subscriptionStatus = $subscription->status;

            // Verificar si están sincronizados
            $isSynced = $this->areStatusesSynced($storeStatus, $subscriptionStatus);

            if ($isSynced) {
                $stats['already_synced']++;
                continue;
            }

            // Detectar tipo de desincronización
            $syncAction = $this->determineSyncAction($store, $subscription);

            if ($syncAction === 'skip') {
                $this->line("  ⏭️  {$store->name} - Omitida (suspensión manual: {$store->suspension_reason})");
                $stats['skipped_manual']++;
                continue;
            }

            try {
                if ($syncAction === 'sync_from_subscription') {
                    $this->syncStoreFromSubscription($store, $subscription, $isDryRun);
                    $stats['synced_from_subscription']++;
                } elseif ($syncAction === 'sync_from_store') {
                    $this->syncSubscriptionFromStore($store, $subscription, $isDryRun);
                    $stats['synced_from_store']++;
                }
            } catch (\Exception $e) {
                $this->error("  ❌ {$store->name} - Error: " . $e->getMessage());
                Log::error('Error sincronizando estado tienda-suscripción', [
                    'store_id' => $store->id,
                    'error' => $e->getMessage()
                ]);
                $stats['errors']++;
            }
        }

        // Mostrar resumen
        $this->newLine();
        $this->info('📊 RESUMEN:');
        $this->info("✅ Ya sincronizadas: {$stats['already_synced']}");
        $this->info("🔄 Tiendas sincronizadas desde suscripción: {$stats['synced_from_subscription']}");
        $this->info("🔄 Suscripciones sincronizadas desde tienda: {$stats['synced_from_store']}");
        $this->info("⏭️  Omitidas (suspensión manual): {$stats['skipped_manual']}");
        
        if ($stats['errors'] > 0) {
            $this->error("❌ Errores: {$stats['errors']}");
        }

        if ($isDryRun) {
            $this->warn("\n⚠️  Esto fue una simulación - no se realizaron cambios");
        } else {
            $this->info("\n🎉 ¡Sincronización completada exitosamente!");
        }

        return 0;
    }

    /**
     * Verificar si los estados están sincronizados
     */
    protected function areStatusesSynced(string $storeStatus, string $subscriptionStatus): bool
    {
        // Mapeo de estados
        $statusMap = [
            'active' => Subscription::STATUS_ACTIVE,
            'suspended' => Subscription::STATUS_SUSPENDED,
            'inactive' => Subscription::STATUS_SUSPENDED, // Inactive se mapea a suspended
        ];

        $expectedSubscriptionStatus = $statusMap[$storeStatus] ?? Subscription::STATUS_ACTIVE;

        return $subscriptionStatus === $expectedSubscriptionStatus;
    }

    /**
     * Determinar qué acción de sincronización tomar
     */
    protected function determineSyncAction(Store $store, Subscription $subscription): string
    {
        $storeStatus = $store->status;
        $subscriptionStatus = $subscription->status;

        // Si la tienda está suspendida manualmente (no por suscripción), no sincronizar
        if ($storeStatus === 'suspended' && 
            !empty($store->suspension_reason) && 
            $store->suspension_reason !== 'subscription_suspended') {
            return 'skip';
        }

        // Prioridad: La suscripción es la fuente de verdad para facturación
        // Si la suscripción está suspended pero la tienda está active, sincronizar tienda
        if ($subscriptionStatus === Subscription::STATUS_SUSPENDED && $storeStatus === 'active') {
            return 'sync_from_subscription';
        }

        // Si la suscripción está active pero la tienda está suspended (sin razón manual), sincronizar tienda
        if ($subscriptionStatus === Subscription::STATUS_ACTIVE && $storeStatus === 'suspended') {
            if (empty($store->suspension_reason) || $store->suspension_reason === 'subscription_suspended') {
                return 'sync_from_subscription';
            }
        }

        // Si la tienda cambió manualmente y no hay razón de suspensión manual, sincronizar suscripción
        if ($storeStatus === 'suspended' && empty($store->suspension_reason)) {
            return 'sync_from_store';
        }

        return 'skip';
    }

    /**
     * Sincronizar tienda desde suscripción
     */
    protected function syncStoreFromSubscription(Store $store, Subscription $subscription, bool $isDryRun): void
    {
        $oldStatus = $store->status;
        $newStatus = $subscription->status === Subscription::STATUS_SUSPENDED ? 'suspended' : 'active';

        $this->line("  🔄 {$store->name} - Tienda: {$oldStatus} → {$newStatus} (desde suscripción: {$subscription->status})");

        if (!$isDryRun) {
            if ($newStatus === 'suspended') {
                $store->update([
                    'status' => 'suspended',
                    'suspension_reason' => 'subscription_suspended',
                    'suspended_at' => now(),
                ]);
            } else {
                $store->update([
                    'status' => 'active',
                    'suspension_reason' => null,
                    'suspended_at' => null,
                    'suspended_invoice_id' => null,
                ]);
            }

            Log::info('🔄 SYNC COMMAND: Tienda sincronizada desde suscripción', [
                'store_id' => $store->id,
                'store_name' => $store->name,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'subscription_status' => $subscription->status,
            ]);
        }
    }

    /**
     * Sincronizar suscripción desde tienda
     */
    protected function syncSubscriptionFromStore(Store $store, Subscription $subscription, bool $isDryRun): void
    {
        $oldStatus = $subscription->status;
        $newStatus = $store->status === 'suspended' ? Subscription::STATUS_SUSPENDED : Subscription::STATUS_ACTIVE;

        $this->line("  🔄 {$store->name} - Suscripción: {$oldStatus} → {$newStatus} (desde tienda: {$store->status})");

        if (!$isDryRun) {
            $subscription->update([
                'status' => $newStatus,
                'metadata' => array_merge($subscription->metadata ?? [], [
                    'synced_from_store_status' => true,
                    'synced_at' => now()->toISOString(),
                ])
            ]);

            Log::info('🔄 SYNC COMMAND: Suscripción sincronizada desde tienda', [
                'store_id' => $store->id,
                'store_name' => $store->name,
                'subscription_id' => $subscription->id,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'store_status' => $store->status,
            ]);
        }
    }
}
