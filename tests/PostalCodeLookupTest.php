<?php

namespace Angle\Mexico\Tests;

use Angle\Mexico\PostalCode\PostalCode;

use PHPUnit\Framework\TestCase;

final class PostalCodeLookupTest extends TestCase
{
    public function testValidLookup(): void
    {
        // 1.A TEST A REAL POSTAL CODE
        $samplePostalCode = '64800';
        //$postalCode = PostalCode::lookup($samplePostalCode);
        $postalCode = PostalCode::fastLookup($samplePostalCode);

        $this->assertInstanceOf(PostalCode::class, $postalCode);

        /*
        printf('Postal Code %s debug:', $samplePostalCode);
        print_r($postalCode);

        echo PHP_EOL . PHP_EOL;
        */

        // 1.B TEST ANOTHER REAL POSTAL CODE
        $samplePostalCode = '85203'; // Cajeme, Sonora.. this one has 310 settlements
        $postalCode = PostalCode::lookup($samplePostalCode);

        $this->assertInstanceOf(PostalCode::class, $postalCode);

        /*
        printf('Postal Code %s debug:', $samplePostalCode);
        print_r($postalCode);

        echo PHP_EOL . PHP_EOL;
        */

        // 1.C TEST ANOTHER REAL POSTAL CODE
        $samplePostalCode = '01090';
        $postalCode = PostalCode::lookup($samplePostalCode);

        $this->assertInstanceOf(PostalCode::class, $postalCode);

        // 1.D TEST ANOTHER REAL POSTAL CODE
        $samplePostalCode = '99998'; // last known postal code, check EOF parsing
        $postalCode = PostalCode::lookup($samplePostalCode);

        $this->assertInstanceOf(PostalCode::class, $postalCode);
    }

    public function testNonExistingLookup(): void
    {
        // 2. TEST A NON-EXISTING POSTAL CODE
        $nonExistingPostalCode = '00000';
        $postalCode = PostalCode::lookup($nonExistingPostalCode);
        $this->assertNull($postalCode);
    }

    public function testLookup(): void
    {
        // 3. TEST A MALFORMED POSTAL CODE
        $malformedPostalCode = 'MALFORMED';
        $postalCode = PostalCode::lookup($malformedPostalCode);
        $this->assertNull($postalCode);
    }
}