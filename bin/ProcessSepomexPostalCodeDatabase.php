#!/usr/bin/env php
<?php

require(dirname(__FILE__) . '/../vendor/autoload.php');

// CP stands for "Código Postal"..
$filename = dirname(__FILE__) . '/../resources/CPdescarga.txt';

$file = fopen($filename, "r");

if (!$file) {
    die('ERROR - Cannot open INPUT file');
}


$outputFilename = dirname(__FILE__) . '/../resources/mx-postal-codes.csv';

$output = fopen($outputFilename, "w+");

if (!$output) {
    die('ERROR - Cannot open OUTPUT file');
}

$matrix = [];

$n = 0;
while (($line = fgets($file)) !== false) {
    $n++;

    // File's encoding is "Windows-1252"
    $row =  mb_convert_encoding($line, "UTF-8", "Windows-1252");

    if ($n == 1) {
        // skip the first line (SEPOMEX disclaimer)
        // but first, print it out to verify encoding
        printf("SEPOMEX Disclaimer: %s" . PHP_EOL, $row);
        continue;
    }

    $fields = str_getcsv($row, '|');

    if ($n == 2) {
        // skip the second line (headers), but first print them out to verify
        pretty_print('HEADERS', $fields);
        continue;
    }

    // Pull the fields of interest
    $code       = $fields[0];
    $settlementName = $fields[1];
    $settlementId   = $fields[12];
    $typeCode   = $fields[10]; // Settlement Type
    $county     = $fields[3];
    $city       = $fields[5];
    $stateCode  = $fields[7];
    $countyCode = $fields[11];
    $zone       = $fields[13];
    $cityCode   = $fields[14];

    if (!array_key_exists($code, $matrix)) {
        // this is the first occurrence of this postal code, initialize it's array
        $matrix[$code] = [
            'stateCode' => $stateCode,
            'settlements' => [],
        ];
    }

    $matrix[$code]['settlements'][] = [
        'i' => $settlementId, // id
        't' => $typeCode, // type
        'n' => $settlementName, // name
        'c' => $city, // city
        'o' => $county, // county
        'z' => \Angle\Mexico\PostalCode\ZoneType::getKeyFromName($zone), // zone
    ];
}

// Cast the Matrix into a single line to store in a CSV file
foreach ($matrix as $postalCode => $data) {
    $line = fputcsv($output, [$postalCode, $data['stateCode'], encode_settlements($data['settlements'])], "|", "_");
}

echo "ALL DONE.";

function encode_settlements($settlements): string
{
    $line = '';

    foreach ($settlements as $s) {
        $line .= $s['i'] . '+' . $s['t'] . '+' . $s['n'] . '+' . $s['c'] . '+' . $s['o'] . '+' . $s['z'] . '&';
    }

    $line = rtrim($line, '&');

    return $line;
}

function pretty_print(string $title, array $array)
{
    printf("~~ %s (%d) ~~" . PHP_EOL, $title, count($array));

    foreach ($array as $k => $f) {
        printf("%02s - %s" . PHP_EOL, $k, $f);
    }

    echo PHP_EOL;
}