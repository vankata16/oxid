<?php

namespace App\Controllers;

interface CurrencyConverterInterface
{
    public function convertCurrency(string $dataURL, float $amount, string $currency, string $outputFormat = "json"): string;
}
