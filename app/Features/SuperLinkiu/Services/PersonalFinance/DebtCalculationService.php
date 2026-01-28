<?php

namespace App\Features\SuperLinkiu\Services\PersonalFinance;

use App\Features\SuperLinkiu\Models\PersonalFinance\Debt;
use App\Features\SuperLinkiu\Models\PersonalFinance\Installment;
use Carbon\Carbon;

class DebtCalculationService
{
    /**
     * Generar cuotas automáticamente para una deuda
     */
    public function generateInstallments(Debt $debt): void
    {
        $totalAmount = $debt->total_amount;
        $totalInstallments = $debt->total_installments;
        $installmentAmount = $debt->installment_amount; // Monto fijo de cuota si se especifica
        $startDate = Carbon::parse($debt->start_date);
        $frequency = $debt->payment_frequency;
        $interestRate = $debt->interest_rate ?? 0;

        // Calcular intervalo según frecuencia
        $interval = match($frequency) {
            'daily' => 1,
            'weekly' => 7,
            'biweekly' => 14,
            'monthly' => 30,
            default => 30,
        };

        // Si tiene interés Y el interés NO está incluido en el monto, calcular con amortización
        // Si el interés ya está incluido, dividir el monto directamente sin calcular interés adicional
        if ($interestRate > 0 && !$debt->interest_included) {
            $this->generateInstallmentsWithInterest($debt, $startDate, $interval);
        } else {
            // Sin interés o interés incluido: dividir monto total entre número de cuotas
            // Si se especifica un monto de cuota fijo, usar ese monto para todas las cuotas
            if ($installmentAmount && $installmentAmount > 0) {
                // Usar el monto de cuota especificado (todas las cuotas iguales)
                $fixedAmount = round($installmentAmount, 2);
                
                // Calcular diferencia por redondeo
                $totalFixed = $fixedAmount * $totalInstallments;
                $difference = $totalAmount - $totalFixed;
                
                for ($i = 1; $i <= $totalInstallments; $i++) {
                    $dueDate = $startDate->copy()->addDays($interval * ($i - 1));
                    
                    // Última cuota: ajustar diferencia por redondeo si existe
                    if ($i === $totalInstallments && abs($difference) > 0.01) {
                        $amount = round($fixedAmount + $difference, 2);
                    } else {
                        $amount = $fixedAmount;
                    }
                    
                    Installment::create([
                        'debt_id' => $debt->id,
                        'installment_number' => $i,
                        'amount' => $amount,
                        'due_date' => $dueDate,
                        'status' => Installment::STATUS_PENDING,
                    ]);
                }
            } else {
                // Dividir monto total entre número de cuotas
                $amountPerInstallment = $totalAmount / $totalInstallments;
                
                // Calcular el monto fijo redondeado
                $fixedAmount = round($amountPerInstallment, 2);
                
                // Calcular diferencia por redondeo
                $totalFixed = $fixedAmount * $totalInstallments;
                $difference = $totalAmount - $totalFixed;
                
                for ($i = 1; $i <= $totalInstallments; $i++) {
                    $dueDate = $startDate->copy()->addDays($interval * ($i - 1));
                    
                    // Última cuota: ajustar diferencia por redondeo para que sume exactamente el total
                    if ($i === $totalInstallments && abs($difference) > 0.01) {
                        $amount = round($fixedAmount + $difference, 2);
                    } else {
                        // Todas las demás cuotas: exactamente iguales
                        $amount = $fixedAmount;
                    }
                    
                    Installment::create([
                        'debt_id' => $debt->id,
                        'installment_number' => $i,
                        'amount' => $amount,
                        'due_date' => $dueDate,
                        'status' => Installment::STATUS_PENDING,
                    ]);
                }
            }
        }

        // Calcular fecha de finalización estimada
        $endDate = $startDate->copy()->addDays($interval * ($totalInstallments - 1));
        $debt->update(['end_date' => $endDate]);
    }

    /**
     * Generar cuotas con interés (amortización)
     */
    protected function generateInstallmentsWithInterest(Debt $debt, Carbon $startDate, int $interval): void
    {
        $principal = $debt->total_amount;
        $rate = ($debt->interest_rate / 100) / 12; // Tasa mensual
        $periods = $debt->total_installments;

        // Calcular cuota fija con fórmula de amortización
        if ($rate > 0) {
            $monthlyPayment = $principal * ($rate * pow(1 + $rate, $periods)) / (pow(1 + $rate, $periods) - 1);
        } else {
            $monthlyPayment = $principal / $periods;
        }

        $balance = $principal;

        for ($i = 1; $i <= $periods; $i++) {
            $interest = $balance * $rate;
            $principalPayment = $monthlyPayment - $interest;
            $balance -= $principalPayment;

            $dueDate = $startDate->copy()->addDays($interval * ($i - 1));

            Installment::create([
                'debt_id' => $debt->id,
                'installment_number' => $i,
                'amount' => round($monthlyPayment, 2),
                'due_date' => $dueDate,
                'status' => Installment::STATUS_PENDING,
            ]);
        }
    }
}
