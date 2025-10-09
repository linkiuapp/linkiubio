<?php

namespace App\Services;

class RUTValidationService
{
    /**
     * Validar formato de NIT colombiano
     */
    public function validateNIT(string $nit): bool
    {
        // Remover puntos y guiones
        $nit = preg_replace('/[^0-9]/', '', $nit);
        
        // Debe tener entre 9 y 10 dígitos
        if (strlen($nit) < 9 || strlen($nit) > 10) {
            return false;
        }
        
        // Validar dígito de verificación
        return $this->validateNITCheckDigit($nit);
    }

    /**
     * Validar formato de Cédula colombiana
     */
    public function validateCC(string $cc): bool
    {
        // Remover puntos
        $cc = preg_replace('/[^0-9]/', '', $cc);
        
        // Debe tener entre 6 y 10 dígitos
        return strlen($cc) >= 6 && strlen($cc) <= 10 && ctype_digit($cc);
    }

    /**
     * Validar dígito de verificación de NIT
     */
    private function validateNITCheckDigit(string $nit): bool
    {
        if (strlen($nit) < 9) {
            return false;
        }

        $checkDigit = (int)substr($nit, -1);
        $number = substr($nit, 0, -1);
        
        $primes = [71, 67, 59, 53, 47, 43, 41, 37, 29, 23, 19, 17, 13, 7, 3];
        $sum = 0;
        
        for ($i = 0; $i < strlen($number); $i++) {
            $sum += (int)$number[$i] * $primes[strlen($number) - 1 - $i];
        }
        
        $calculatedDigit = $sum % 11;
        $calculatedDigit = $calculatedDigit > 1 ? 11 - $calculatedDigit : $calculatedDigit;
        
        return $checkDigit === $calculatedDigit;
    }

    /**
     * Formatear NIT
     */
    public function formatNIT(string $nit): string
    {
        $nit = preg_replace('/[^0-9]/', '', $nit);
        
        if (strlen($nit) < 9) {
            return $nit;
        }
        
        $number = substr($nit, 0, -1);
        $checkDigit = substr($nit, -1);
        
        // Formatear: XXX.XXX.XXX-X
        $formatted = '';
        $number = strrev($number);
        
        for ($i = 0; $i < strlen($number); $i++) {
            if ($i > 0 && $i % 3 === 0) {
                $formatted = '.' . $formatted;
            }
            $formatted = $number[$i] . $formatted;
        }
        
        return $formatted . '-' . $checkDigit;
    }

    /**
     * Formatear Cédula
     */
    public function formatCC(string $cc): string
    {
        $cc = preg_replace('/[^0-9]/', '', $cc);
        
        if (strlen($cc) < 4) {
            return $cc;
        }
        
        // Formatear: X.XXX.XXX
        $formatted = '';
        $cc = strrev($cc);
        
        for ($i = 0; $i < strlen($cc); $i++) {
            if ($i > 0 && $i % 3 === 0) {
                $formatted = '.' . $formatted;
            }
            $formatted = $cc[$i] . $formatted;
        }
        
        return $formatted;
    }

    /**
     * Validar según tipo
     */
    public function validate(string $documentType, string $documentNumber): bool
    {
        return match($documentType) {
            'NIT', 'RUT' => $this->validateNIT($documentNumber),
            'CC', 'CE' => $this->validateCC($documentNumber),
            default => false
        };
    }

    /**
     * Formatear según tipo
     */
    public function format(string $documentType, string $documentNumber): string
    {
        return match($documentType) {
            'NIT', 'RUT' => $this->formatNIT($documentNumber),
            'CC', 'CE' => $this->formatCC($documentNumber),
            default => $documentNumber
        };
    }
}

