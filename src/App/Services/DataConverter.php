<?php

namespace App\Services;

class DataConverter implements DataConverterInterface
{
    public function convertToJSON(array $data): string
    {
        return json_encode($data);
    }

    public function convertToCSV(array $data): string
    {
        $convertedData = [];
        foreach ($data as $currencyCode => $money) {
            $convertedData[$currencyCode] = $money->getAmount()->toFloat();
        }
        return implode(',', $convertedData);
    }

}