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
        $csv = '';

        foreach ($data as $row) {
            $csv .= implode(',', $row) . "\n";
        }

        return $csv;
    }
}