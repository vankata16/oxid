<?php

namespace App\Controllers;

use App\Controllers\CurrencyConverterInterface;
use Brick\Money\Money;
use Brick\Money\Currency;
use Brick\Math\RoundingMode;
use Brick\Money\Context\CustomContext;
use App\Services\CurrencyDataService;
use App\Services\DataConverter;

class CurrencyConversionController implements CurrencyConverterInterface
{
    private CurrencyDataService $dataService;
    private DataConverter $dataConverter;

    public function __construct(
        CurrencyDataService $dataService,
        DataConverter $dataConverter
    ) {
        $this->setDataService($dataService);
        $this->dataConverter = $dataConverter;
    }

    public function setDataService(CurrencyDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Converts the given amount from one currency to multiple currencies.
     *
     * @param string $dataURL The URL to download the currency exchange rate data from.
     * @param float $amount The amount to convert.
     * @param string $currency The currency code to convert from.
     * @param string $outputFormat The desired output format (json or csv).
     * @return string The converted result in the specified output format.
     * @throws \InvalidArgumentException When an invalid output format is specified.
     */
    public function convertCurrency(string $dataURL, float $amount, string $currency, string $outputFormat = "json"): string
    {
        // Download the currency exchange rate data
        $data = $this->dataService->downloadData($dataURL);

        // Get the base rate for the conversion
        $baseRate = $data['exchangeRates'][$currency];

        // Create the Currency object for the base currency
        $baseCurrency = Currency::of($currency);

        $convertedCurrencies = [];

        // Perform currency conversion for each currency
        foreach ($data['exchangeRates'] as $currencyCode => $rate) {
            // Convert the rate relative to the base rate and multiply by the amount
            $convertedCurrencies[$currencyCode] = Money::of($rate, $currencyCode, new CustomContext(12, RoundingMode::HALF_UP), RoundingMode::HALF_UP)
                ->dividedBy($baseRate, RoundingMode::HALF_DOWN)
                ->multipliedBy($amount, RoundingMode::HALF_DOWN);
        }

        // Convert the result to the specified output format
        if ($outputFormat === 'csv') {
            $result = $this->dataConverter->convertToCSV($convertedCurrencies);
        } elseif ($outputFormat === 'json') {
            $result = $this->dataConverter->convertToJSON($convertedCurrencies);
        } else {
            throw new \InvalidArgumentException('Invalid output format specified.');
        }

        return $result;
    }
}
