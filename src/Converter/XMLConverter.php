<?php

namespace App\Converter;

use DOMElement;

class XMLConverter
{
    public static function xmlToArray(string $filepath): array
    {
        // Read entire file into string
        $xmlfile = file_get_contents($filepath);

        // Convert xml string into an object
        $xmlToObject = simplexml_load_string($xmlfile);

        // Convert into json
        $objectToJson = json_encode($xmlToObject);

        // Convert into associative array
        $data = json_decode($objectToJson, true);

        return $data;
    }
}

