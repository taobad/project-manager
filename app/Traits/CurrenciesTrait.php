<?php

namespace App\Traits;

use Money\Currencies;
use Money\Currencies\ISOCurrencies;

trait CurrenciesTrait
{
    /**
     * @var \Money\Currencies
     */
    protected static $currencies;

    /**
     * Get currencies.
     *
     * @return \Money\Currencies
     */
    public static function getCurrencies()
    {
        if (!isset(static::$currencies)) {
            static::setCurrencies(new ISOCurrencies());
        }

        return static::$currencies;
    }

    /**
     * Set currencies.
     *
     * @param \Money\Currencies $currencies
     */
    public static function setCurrencies(Currencies $currencies)
    {
        static::$currencies = $currencies;
    }
}
