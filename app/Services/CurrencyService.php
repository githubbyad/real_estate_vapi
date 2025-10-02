<?php

namespace App\Services;

use Illuminate\Support\Number;

class CurrencyService
{
    private static $currency = 'INR'; // Default currency
    private static $currencySymbol = '₹'; // Default currency symbol

    public static function setCurrency($currency)
    {
        self::$currency = strtoupper($currency);
        self::$currencySymbol = self::getCurrencySymbol(self::$currency);
    }

    public static function getCurrency()
    {
        return self::$currency;
    }

    public static function getCurrencySymbol($currency = null)
    {
        $currency = $currency ? strtoupper($currency) : self::$currency;
        $symbols = [
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'INR' => '₹',
            'JPY' => '¥',
            'CNY' => '¥',
            'AUD' => 'A$',
            'CAD' => 'C$',
            // Add more currencies as needed
        ];

        return $symbols[$currency] ?? $currency; // Return currency code if symbol not found
    }

    public static function formatAmount($amount, $currency = null)
    {
        $currency = $currency ? strtoupper($currency) : self::$currency;
        $symbol = self::getCurrencySymbol($currency);
        
        // Custom formatting for INR and other currencies
        if ($currency === 'INR') {
            // Format INR with Indian numbering system (e.g., 1,23,456.78)
            $number = number_format((float)$amount, 2, '.', '');
            $parts = explode('.', $number);
            $integerPart = $parts[0];
            $decimalPart = isset($parts[1]) ? '.' . $parts[1] : '';

            // Apply Indian formatting to the integer part
            $lastThree = substr($integerPart, -3);
            $rest = substr($integerPart, 0, -3);
            if ($rest !== '') {
                $rest = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $rest);
                $integerPart = $rest . ',' . $lastThree;
            }

            $number = $integerPart . $decimalPart;
        } else {
            // For other currencies, use standard formatting
            if (floor($amount) == $amount) {
                $number = number_format((float)$amount, 0);
            } else {
                $number = number_format((float)$amount, 2);
            }
        }

        // Place symbol before or after number based on currency
        if (in_array($currency, ['USD', 'EUR', 'GBP', 'INR', 'JPY', 'CNY'])) {
            return $symbol . " " . $number;
        }
        return $number . " " . $symbol;
    }
}
