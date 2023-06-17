<?php

namespace App\Services;

interface DataConverterInterface
{
    public function convertToJSON(array $data): string;

    public function convertToCSV(array $data): string;
}
