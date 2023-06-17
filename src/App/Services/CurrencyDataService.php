<?php

namespace App\Services;

class CurrencyDataService
{
    public function downloadData($dataURL): array
    {
        $data = file_get_contents($dataURL);

        if ($data === false) {
            throw new \Exception('Unable to download data from URL: ' . $dataURL);
        }

        // check the data type
        if (json_decode($data) !== null) {
            $data = \App\Services\DataParsers\JSONDataParser::parse($data);
        }
        else if ($this->isCsv($data)) {
            $data = \App\Services\DataParsers\CSVDataParser::parse($data);
        }
        else if ($this->isXml($data)) {
            $data = \App\Services\DataParsers\XMLDataParser::parse($data);
        }
        else {
            throw new \InvalidArgumentException('Invalid data format');
        }

        if (!$this->validateData($data)) {
            throw new \InvalidArgumentException('Invalid data format');
        }

        return $data;
    }

    private function isXml($data) {
        libxml_use_internal_errors(true);
    
        // Attempt to load the string as XML
        $xml = simplexml_load_string($data);
    
        if ($xml === false) {
            return false;
        }
    
        return true;
    }

    function isCsv($data) {
        $lines = explode(PHP_EOL, $data); 
    
        if (count($lines) <= 1) {
            return false;
        }
    
        $firstLine = str_getcsv($lines[0]); 
    
        if (count($firstLine) <= 1) {
            return false; 
        }
    
        return true;
    }

    public function validateData(array $data): bool
    {
        // Perform data type validation here
        // Return true if data is valid, false otherwise
        return isset($data['baseCurrency']) && isset($data['exchangeRates']);
    }
}
