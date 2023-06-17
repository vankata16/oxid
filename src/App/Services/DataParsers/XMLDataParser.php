<?php

namespace App\Services\DataParsers;

class XMLDataParser implements DataParserInterface
{
    public static function parse(string $data): array
    {
        $xml = simplexml_load_string($data);
        $json = json_encode($xml);

        return json_decode($json, true) ?? [];
    }
}