<?php

namespace App\Converter;

use DOMElement;

class XMLConverter
{
    public static function xmlToArray(string $filepath): array
    {
        // Read entire file into string
        $xmlfile = file_get_contents($filepath);

        $base = array('<ul>', '</ul>', '<li>', '</li>', '<strong>', '</strong>');
        $replace = array('', '', '\t', '', '', '');
        $xmlfile = str_replace($base, $replace, $xmlfile);
        $xmlfile = str_replace('<br />', '\n', $xmlfile);

        // Convert xml string into an object
        $xmlToObject = simplexml_load_string($xmlfile);

        // Convert into json
        $objectToJson = json_encode($xmlToObject);

        // Convert into associative array
        $data = json_decode($objectToJson, true);

        return $data;
    }
}

