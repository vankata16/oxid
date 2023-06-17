<?php

namespace App\Services\DataParsers;

class CSVDataParser implements DataParserInterface
{
    public static function parse(string $data): array
    {
        $rows = explode(PHP_EOL, $data);
        $header = str_getcsv(array_shift($rows));
        $data = [];

        foreach ($rows as $row) {
            $data[] = array_combine($header, str_getcsv($row));
        }

        return $data;
    }
}