<?php

// Require the Composer autoloader
require 'vendor/autoload.php';

use App\Controllers\CurrencyConversionController;
use App\Services\CurrencyDataService;
use App\Services\DataConverter;

// Instantiate the CurrencyDataService
$dataService = new CurrencyDataService();
$dataConverter = new DataConverter();

// Instantiate the CurrencyConversionController
$conversionController = new CurrencyConversionController($dataService, $dataConverter);


// Call the convertCurrency method
$amount = 100; // The amount to convert
$currencyCode = 'BGN'; // The currency code to convert from
$outputFormat = 'json'; // The desired output format (json or csv)

$convertedResult = $conversionController->convertCurrency("currencyData.json", $amount, $currencyCode, $outputFormat);

// Display the converted result
echo $convertedResult;
