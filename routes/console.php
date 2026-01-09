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

// 🧪 Programar procesamiento de vencimientos de trials (diariamente a las 7am)
Schedule::command('trial:process-expirations --notify')
    ->dailyAt('07:00')
    ->name('trial-process-expirations')
    ->description('Process trial period expirations: generate invoices, send warnings, and suspend if needed');

// ✅ Programar verificación de solicitudes de tiendas pendientes (cada hora)
Schedule::command('stores:check-pending-requests')
    ->hourly()
    ->name('check-pending-store-requests')
    ->description('Check pending store requests and alert if >6h or >24h without review');

// ✅ Programar limpieza de solicitudes rechazadas antiguas (cada semana)
Schedule::command('stores:cleanup-old-requests --days=90')
    ->weekly()
    ->sundays()
    ->at('02:00')
    ->name('cleanup-old-store-requests')
    ->description('Clean up rejected store requests older than 90 days');

// 🎫 Programar cierre automático de tickets inactivos (diariamente)
Schedule::command('tickets:auto-close-inactive --days=7')
    ->dailyAt('00:00')
    ->name('auto-close-inactive-tickets')
    ->description('Auto-close resolved tickets after 7 days of inactivity');

// 📅 Programar recordatorios de reservaciones (cada 2 horas)
Schedule::command('reservations:send-reminders')
    ->everyTwoHours()
    ->name('reservation-reminders')
    ->description('Send WhatsApp reminders for confirmed reservations based on store settings');

// 📊 Programar verificación de alertas de monitoreo (cada 5 minutos)
Schedule::command('monitoring:check-alerts')
    ->everyFiveMinutes()
    ->name('monitoring-check-alerts')
    ->description('Check monitoring alerts and trigger notifications if needed');

// 🧹 Programar limpieza de logs antiguos (diariamente)
Schedule::command('monitoring:clean-logs --days=30')
    ->dailyAt('02:00')
    ->name('monitoring-clean-logs')
    ->description('Clean old monitoring logs from database');

// 📋 LinkiuDev - Resumen diario de agenda (cada minuto, el comando verifica la hora)
Schedule::command('linkiudev:send-daily-summary')
    ->everyMinute()
    ->name('linkiudev-daily-summary')
    ->description('Send daily agenda summary via WhatsApp at configured time');

// ⏰ LinkiuDev - Recordatorios de tareas (cada 5 minutos)
Schedule::command('linkiudev:send-task-reminders')
    ->everyFiveMinutes()
    ->name('linkiudev-task-reminders')
    ->description('Send task and event reminders via WhatsApp');

// 💳 SubscriptionDev - Recordatorios de pago de suscripciones (diariamente a las 9am)
Schedule::command('subscriptiondev:send-reminders')
    ->dailyAt('09:00')
    ->name('subscriptiondev-payment-reminders')
    ->description('Send subscription payment reminders via WhatsApp');
