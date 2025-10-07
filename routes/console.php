<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Programar notificaciones de suscripciones
Schedule::command('subscription:send-notifications')
    ->dailyAt('09:00')
    ->name('subscription-notifications')
    ->description('Send subscription renewal and expiration notifications');

// Programar verificación de suscripciones vencidas
Schedule::command('subscription:send-notifications')
    ->dailyAt('18:00')
    ->name('subscription-evening-check')
    ->description('Evening check for subscription notifications');

// Programar sincronización de facturas con suscripciones
Schedule::command('billing:sync-invoices')
    ->dailyAt('06:00')
    ->name('billing-sync')
    ->description('Sync invoices with subscriptions and generate automatic invoices');

// Programar actualización de facturas vencidas cada 6 horas
Schedule::command('billing:sync-invoices')
    ->everySixHours()
    ->name('billing-overdue-check')
    ->description('Check and update overdue invoices');

// Programar recordatorios de pago (7 días antes, 3 días antes, 1 día después)
Schedule::command('invoices:send-reminders')
    ->dailyAt('08:00')
    ->name('payment-reminders')
    ->description('Send payment reminders before and after due date');

// Programar suspensión automática de tiendas con facturas vencidas (+7 días)
Schedule::command('stores:suspend-overdue')
    ->dailyAt('10:00')
    ->name('suspend-overdue-stores')
    ->description('Suspend stores with invoices overdue for more than 7 days');
