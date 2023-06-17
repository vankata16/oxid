# Currency Conversion Application

This is a currency conversion application that allows you to convert an amount from one currency to multiple currencies based on the exchange rates provided in a data source. The application supports conversion to JSON or CSV output formats.

## Features

- Fetches currency exchange rate data from a specified URL.
- Converts an amount from one currency to multiple currencies based on the fetched exchange rates.
- Supports conversion output in JSON or CSV format.

## Installation

1. Clone the repository:

git clone https://github.com/vankata16/oxid/

2. Install dependencies using Composer:

composer install


3. Set up your web server to serve the application from the appropriate directory.

## Usage

1. Create an instance of the `CurrencyConversionController` class, providing the required dependencies (`CurrencyDataService` and `DataConverterInterface`).

2. Call the `convertCurrency` method on the controller instance, passing the necessary parameters:
   - `dataURL`: The URL to download the currency exchange rate data from.
   - `amount`: The amount to convert.
   - `currency`: The currency code to convert from.
   - `outputFormat`: (Optional) The desired output format (json or csv). Default is json.

3. The method will return the converted result in the specified output format.

Example usage:

```php
$converter = new CurrencyConversionController(new CurrencyDataService(), new JSONDataConverter());

// Call the convertCurrency method
$dataURL = 'https://example.com/currency-data.json';
$amount = 100; // The amount to convert
$currencyCode = 'USD'; // The currency code to convert from
$outputFormat = 'json'; // The desired output format (json or csv)

$convertedResult = $converter->convertCurrency($dataURL, $amount, $currencyCode, $outputFormat);
``
Data Source
The application requires a data source for currency exchange rate data. Currently, it supports data in JSON format. The data source should provide exchange rates for various currencies.

The expected structure of the JSON data is as follows:

{
  "exchangeRates": {
    "USD": 1.2,
    "EUR": 0.9,
    "GBP": 0.8,
    ...
  }
}
