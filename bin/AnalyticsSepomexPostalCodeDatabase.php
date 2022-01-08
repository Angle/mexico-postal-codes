#!/usr/bin/env php
<?php

if (!function_exists('array_key_first')) {
    function array_key_first(array $arr) {
        foreach($arr as $key => $unused) {
            return $key;
        }
        return NULL;
    }
}

require(dirname(__FILE__) . '/../vendor/autoload.php');

// CP stands for "Código Postal"..
$filename = dirname(__FILE__) . '/../resources/CPdescarga.txt';

$file = fopen($filename, "r");

if (!$file) {
    die('ERROR - Cannot open INPUT file');
}


// Fields of interest for Analytics:
// Tipo de Asentamiento
$types = [];
$typesInverse = [];

// Entidad
$states = [];
$statesInverse = [];

/*
// Integrity checks
$citiesPerPostalCode = [];
$countiesPerPostalCode = [];
$statesPerPostalCode = [];
*/

$settlementsPerPostalCode = [];

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

    // Populate all fields of interest
    $postalCode = $fields[0];

    $typeCode = $fields[10];
    $typeName = $fields[2];
    $stateCode = $fields[7];
    $stateName = $fields[4];

    $types[$typeCode] = $typeName;
    $typesInverse[$typeName] = $typeCode;

    $states[$stateCode] = $stateName;
    $statesInverse[$stateName] = $stateCode;

    /*
    if ($postalCode == '85203') {
        echo $row . PHP_EOL;
    }
    */

    /*
    // Integrity check
    $city       = $fields[5];
    $county     = $fields[3];
    $state      = $fields[4];

    if ($postalCode == '20174') {
        echo $row . PHP_EOL;
    }

    if (!array_key_exists($postalCode, $statesPerPostalCode)) {
        $statesPerPostalCode[$postalCode] = $state;
    } else {
        if ($statesPerPostalCode[$postalCode] != $state) {

            printf('Woops! state inconsistency for PostalCode %s' . PHP_EOL, $postalCode);
            printf('Existing state: %s' . PHP_EOL, $statesPerPostalCode[$postalCode]);
            printf('New state:      %s' . PHP_EOL, $state);

            die('ERR - Integrity check failed');
        }
    }
    */

    if (!array_key_exists($postalCode, $settlementsPerPostalCode)) {
        $settlementsPerPostalCode[$postalCode] = 1;
    } else {
        $settlementsPerPostalCode[$postalCode] += 1;
    }
}

if (count($types) !== count($typesInverse)) {
    printf('INVALID TYPE MAPPINGS!');

    pretty_print('Code => Name', $types);
    pretty_print('Inverse', $typesInverse);

    die('ERROR');
}

if (count($states) !== count($statesInverse)) {
    printf('INVALID STATE MAPPINGS!');

    pretty_print('Code => Name', $states);
    pretty_print('Inverse', $statesInverse);

    die('ERROR');
}

// Sort the arrays
ksort($types);
ksort($states);

// Print out the Fields of Interest
pretty_print('Types', $types);
pretty_print('States', $states);

// Print out the biggest settlements
printf('PostalCodes found: %s' . PHP_EOL, number_format(count($settlementsPerPostalCode)));

//Find the highest value in the array
//by using PHP's max function.
$maxVal = max($settlementsPerPostalCode);

//Use array_search to find the key that
//the max value is associated with
$maxKey = array_search($maxVal, $settlementsPerPostalCode);

printf('Most settlements found in %s with %d settlements.' . PHP_EOL, $maxKey, $maxVal);


function pretty_print(string $title, array $array)
{
    printf("~~ %s (%d) ~~" . PHP_EOL, $title, count($array));

    foreach ($array as $k => $f) {
        printf("%02s - %s" . PHP_EOL, $k, $f);
    }

    echo PHP_EOL;
}