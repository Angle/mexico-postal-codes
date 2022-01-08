# Angle Mexico Postal Codes
PHP utility and database to lookup Mexico Postal Code information


## How to Use

```php
$postalCode = PostalCode::fastLookup('64630');

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
```

```
Postal Code:    64630
State:          19 NLE Nuevo León
Settlements:
> 330 Colinas de San Jerónimo
  Type:   9 - Colonia
  City:   Monterrey
  County: Monterrey
  Zone:   U - Urbano
> 331 San Jemo
  Type:   9 - Colonia
  City:   Monterrey
  County: Monterrey
  Zone:   U - Urbano
```

## Database Source
The database is downloaded from the official _Correos de México_ website at:
https://www.correosdemexico.gob.mx/SSLServicios/ConsultaCP/CodigoPostal_Exportar.aspx and it is then parsed and processed to optimize the filesize a bit.

_Last database update: January 2, 2022_

The database is published by SEPOMEX (SErvicio POstal MEXicano) and includes a Disclaimer Notice that allows personal use of the data but no commercial use at all. This must be honored by anybody using this PHP library:

> El Catálogo Nacional de Códigos Postales, es elaborado por Correos de México y se proporciona en forma gratuita para uso particular, no estando permitida su comercialización, total o parcial, ni su distribución a terceros bajo ningún concepto.


## Database Processing

To update and autogenerate, place the `CPdescarga.txt` file inside the `resources/` directory, then execute the `ProcessSepomexPostalCodeDatabase.php` script.

- CPdescargatxt.zip -> 2MB compressed file
- CPdescarga.txt -> 14.6MB pipe-separated file
- mx-postal-codes.csv -> 6.94MB nested pipe-separated file

The column definitions can be found in this link: https://www.correosdemexico.gob.mx/SSLServicios/ConsultaCP/imagenes/Descrip.pdf


## Database Analytics
We've included a very basic and barebones analytics script in `AnalyticsSepomexPostalCodeDatabase.php` that parses the raw database and generates a few insights into the data.

Interesting facts from the Jan 2nd, 2022 database:
- There are 31,827 unique PostalCodes in Mexico
- PostalCode 85203 in Cajeme, Sonora, has 310 settlements registered in the same PostalCode.

## Testing

```bash
php vendor/bin/phpunit tests/PostalCodeLookupTest.php
```

## TO-DO
- Implement "database expand" for PostalCodes to minimize the library install size. The current PostalCode database file weights 6.94MB, if we zip it we could reduce it to 1.6MB.
- The "SingleLookup" method for PostalCodes scans the file very quickly before parsing.  This could be further optimized if the database file was ordered by "popularity", or at least by "cities first, rural second".

## References
Some interesting tidbits from https://www.correosdemexico.gob.mx/DatosAbiertos/Normateca/SUS/LOG/LO7.pdf

1. Los dos primeros dígitos identifican una entidad federativa y en el caso de la Ciudad de México una alcaldía.
2. El tercer dígito identifica en las entidades federativas un conjunto de municipios, un municipio o parte de un municipio y en la Ciudad de México parte de una alcaldía
3. El cuarto dígito identifica en las entidades federativas y en la Ciudad de México un conjunto de asentamientos humanos urbanos y rurales.
4. El quinto dígito identifica en las entidades federativas y en la Ciudad de México un conjunto de asentamientos humanos urbanos y rurales o un asentamiento humano urbano rural o una oficina postal.

