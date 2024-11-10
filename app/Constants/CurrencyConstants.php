<?php
namespace App\Constants;

class CurrencyConstants
{
    public const CURRENCY_AED = 0;
    public const CURRENCY_USD = 1;

    public static function getCurrenciesTypes()
    {
        return [
            self::CURRENCY_AED => 'AED',
            self::CURRENCY_USD => 'USD',
        ];
    }

}
