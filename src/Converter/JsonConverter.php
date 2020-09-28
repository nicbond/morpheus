<?php

namespace App\Converter;

class JsonConverter
{
    public static function jsonToArray(string $filepath): array
    {
        $json = file_get_contents($filepath);
        $data = json_decode($json, true);

        return $data;
    }
}
