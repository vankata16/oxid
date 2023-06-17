<?php

namespace App\Services\DataParsers;

interface DataParserInterface
{
    public static function parse(string $data): array;
}
