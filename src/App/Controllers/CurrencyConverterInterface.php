<?php

namespace App\Controllers;

use Brick\Money\Currency;

interface CurrencyConverterInterface
{
    public function convertCurrency(string $dataURL, float $amount, string $currency, string $outputFormat = "json"): string;
}
