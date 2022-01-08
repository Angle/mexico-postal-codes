<?php

namespace Angle\Mexico\PostalCode;

use RuntimeException;

class PostalCode
{
    // Source: https://www.correosdemexico.gob.mx/SSLServicios/ConsultaCP/CodigoPostal_Exportar.aspx

    const REGEX = '/^[0-9]{5}$/';

    const DATABASE_FILE = 'var/mx-postal-codes.csv';

    /** @var PostalCode[] */
    protected static $data = null;

    /** @var string $postalCode */
    protected $postalCode;

    /** @var int $state */
    protected $state;

    /** @var Settlement[] $settlements */
    protected $settlements = [];

    /**
     * @return string
     */
    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     * @return self
     */
    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    /**
     * @return int
     */
    public function getState(): int
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getStateName(): string
    {
        return State::getName($this->state);
    }

    /**
     * @return string
     */
    public function getStateIso(): string
    {
        return State::getIso($this->state);
    }

    /**
     * @param int $state
     * @return self
     */
    public function setState(int $state): self
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @param Settlement $settlement
     * @return $this
     */
    public function addSettlement(Settlement $settlement): self
    {
        foreach ($this->settlements as $k => $set) {
            if ($settlement->getId() == $set->getId() && $settlement->getName() == $set->getName()) {
                // this settlement already exists, we can safely skip it
                return $this;
            }
        }

        // append it
        $this->settlements[] = $settlement;
        return $this;
    }

    /**
     * @param Settlement $settlement
     * @return $this
     */
    public function removeSettlement(Settlement $settlement): self
    {
        foreach ($this->settlements as $k => $set) {
            if ($settlement->getId() == $set->getId() && $settlement->getName() == $set->getName()) {
                unset($this->settlements[$k]);
            }
        }

        $this->settlements[] = $settlement;
        return $this;
    }

    public function getSettlements(): array
    {
        return $this->settlements;
    }



    //////////////////
    // STATIC METHODS

    /**
     * Check if the PostalCode string is valid
     *
     * @param string $postalCode
     * @return bool
     */
    public static function isValid(string $postalCode): bool
    {
        $r = preg_match(self::REGEX, $postalCode, $matches);

        if ($r === 1) {
            return true;
        }

        return false;
    }

    private static function load(): void
    {
        if (self::$data !== null) {
            // the data has already been loaded
            return;
        }

        $file = self::openFile();

        self::$data = [];

        $n = 0;
        while (($line = fgets($file)) !== false) {
            $n++;

            $pc = self::loadLine($line, $n);

            self::$data[$pc->getPostalCode()] = $pc;
        }

        return;
    }

    private static function loadLine(string $line, int $reference=0)
    {
        $fields = str_getcsv($line, '|');

        if (count($fields) !== 3) {
            throw new RuntimeException('Invalid field count in line ' . number_format($reference));
        }

        $postalCode     = $fields[0];
        $stateCode      = $fields[1];
        $settlements    = $fields[2];

        $settlements = trim($settlements, '_');

        // Initialize the PostalCode object
        $pc = new self();
        $pc->setPostalCode($postalCode);
        $pc->setState($stateCode);

        foreach (explode('&', $settlements) as $settlement) {
            $settlementParts = explode('+', $settlement);

            if (count($settlementParts) !== 6) {
                throw new RuntimeException('Invalid settlement part count in line ' . number_format($reference));
            }

            $settlementId   = $settlementParts[0];
            $settlementType = $settlementParts[1];
            $settlementName = $settlementParts[2];
            $city           = $settlementParts[3];
            $county         = $settlementParts[4];
            $zoneType       = $settlementParts[5];

            $settl = new Settlement();
            $settl->setId(intval($settlementId));
            $settl->setType(intval($settlementType));
            $settl->setName($settlementName);
            $settl->setCity($city);
            $settl->setCounty($county);
            $settl->setZone($zoneType);

            $pc->addSettlement($settl);
        }

        return $pc;
    }

    /**
     * Lookup a PostalCode from a database loaded into memory.
     *
     * @param string $postalCode
     * @return PostalCode|null
     */
    public static function lookup(string $postalCode): ?PostalCode
    {
        // Lazy load, this will only attempt to read the database the first time this is called
        self::load();

        if (array_key_exists($postalCode, self::$data)) {
            return self::$data[$postalCode];
        }

        return null;
    }

    /**
     * Lookup a PostalCode, but don't load the complete Database into memory.
     * This might be faster for single lookups, but overall slower for multiple consecutive queries.
     *
     * @param string $postalCode
     * @return PostalCode|null
     */
    public static function fastLookup(string $postalCode): ?PostalCode
    {
        $file = self::openFile();

        $n = 0;
        while (($line = fgets($file)) !== false) {
            $n++;

            $linePostalCode = substr($line, 0, 5);

            if ($postalCode != $linePostalCode) {
                continue;
            }

            return self::loadLine($line, $n);
        }

        return null;
    }

    private static function openFile()
    {
        $filename = dirname(__FILE__) . '/../' . self::DATABASE_FILE;

        $file = fopen($filename, "r");

        if (!$file) {
            // cannot open database file
            throw new RuntimeException('Cannot open database file, looked in: ' . $filename);
        }

        return $file;
    }
}