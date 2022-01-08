#!/usr/bin/env php
<?php

require(dirname(__FILE__) . '/../vendor/autoload.php');


$postalCode = \Angle\Mexico\PostalCode\PostalCode::fastLookup('64630');

printf('Postal Code:    %s' . PHP_EOL, $postalCode->getPostalCode());
printf('State:          %d %s %s' . PHP_EOL, $postalCode->getState(), $postalCode->getStateIso(), $postalCode->getStateName());

printf('Settlements:' . PHP_EOL);

foreach ($postalCode->getSettlements() as $settlement) {
    printf('> %s %s' . PHP_EOL, $settlement->getId(), $settlement->getName());
    printf('  Type:   %s - %s' . PHP_EOL, $settlement->getType(), $settlement->getTypeName());
    printf('  City:   %s' . PHP_EOL, $settlement->getCity());
    printf('  County: %s' . PHP_EOL, $settlement->getCounty());
    printf('  Zone:   %s - %s' . PHP_EOL, $settlement->getZone(), $settlement->getZoneName());
}