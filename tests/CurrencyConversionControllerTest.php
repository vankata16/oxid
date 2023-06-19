<?php

require_once 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\Controllers\CurrencyConversionController;
use App\Services\CurrencyDataService;
use App\Services\DataConverter;
use App\Services\DataConverterInterface;
use Brick\Money\Money;
use Brick\Money\Currency;
use Brick\Math\RoundingMode;

class CurrencyConversionControllerTest extends TestCase
{
    protected function createCurrencyConversionController(): CurrencyConversionController
    {
        $dataService = new CurrencyDataService();
        $dataConverter = new DataConverter(); // Replace with your actual implementation
        return new CurrencyConversionController($dataService, $dataConverter);
    }

    public function testConvertCurrencyReturnsCorrectResultInJSONFormat()
    {
        
        $controller = $this->createCurrencyConversionController();

        // Mock the data service to return a specific data set
        $dataServiceMock = $this->createMock(CurrencyDataService::class);
        $dataServiceMock->method('downloadData')
            ->willReturn([
                'exchangeRates' => [
                    'BGN' => 1.95583,
                    'USD' => 1.2150,
                    'EUR' => 1.0,
                ],
            ]);
        $controller->setDataService($dataServiceMock);

        $amount = 100;
        $currency = 'EUR';
        $outputFormat = 'json';

        $expectedResult = '{"BGN":{"amount":"195.583000000000","currency":"BGN"},"USD":{"amount":"121.500000000000","currency":"USD"},"EUR":{"amount":"100.000000000000","currency":"EUR"}}';

        $result = $controller->convertCurrency('currencyData.json', $amount, $currency, $outputFormat);

        $this->assertEquals($expectedResult, $result);
    }

    // Add more unit tests for different scenarios

    public function testConvertCurrencyThrowsExceptionForInvalidOutputFormat()
    {
        $controller = $this->createCurrencyConversionController();

        $this->expectException(\InvalidArgumentException::class);

        $amount = 100;
        $currency = 'EUR';
        $outputFormat = 'invalid'; // Invalid output format

        $controller->convertCurrency('currencyData.json', $amount, $currency, $outputFormat);
    }

    // Add more unit tests for error cases

    public function testConvertCurrencyIntegration()
    {
        $controller = $this->createCurrencyConversionController();

        $amount = 100;
        $currency = 'EUR';
        $outputFormat = 'csv';

        $result = $controller->convertCurrency('currencyData.json', $amount, $currency, $outputFormat);

        // Assert the result based on your expectations
        $this->assertNotEmpty($result);
        // ...
    }

    // Add more integration tests for different scenarios
}
