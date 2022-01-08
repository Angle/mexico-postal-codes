<?php

namespace Angle\Mexico\PostalCode;

class Settlement
{
    /** @var int $id */
    protected $id;

    /** @var int $type */
    protected $type;

    /** @var string $name */
    protected $name;

    /** @var string|null $city */
    protected $city;

    /** @var string|null $county */
    protected $county;

    /** @var string $zone */
    protected $zone;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getTypeName(): string
    {
        return SettlementType::getName($this->type);
    }

    /**
     * @param int $type
     * @return self
     */
    public function setType(int $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     * @return self
     */
    public function setCity(?string $city): self
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCounty(): ?string
    {
        return $this->county;
    }

    /**
     * @param string|null $county
     * @return self
     */
    public function setCounty(?string $county): self
    {
        $this->county = $county;
        return $this;
    }

    /**
     * @return string
     */
    public function getZone(): string
    {
        return $this->zone;
    }

    /**
     * @return string
     */
    public function getZoneName(): string
    {
        return ZoneType::getName($this->zone);
    }

    /**
     * @param string $zone
     * @return self
     */
    public function setZone(string $zone): self
    {
        $this->zone = $zone;
        return $this;
    }

}