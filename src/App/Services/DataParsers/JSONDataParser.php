<?php

namespace App\Services\DataParsers;

class JSONDataParser implements DataParserInterface
{
    public static function parse(string $data): array
    {
        return json_decode($data, true) ?? [];
    }
}