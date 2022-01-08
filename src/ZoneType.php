<?php

namespace Angle\Mexico\PostalCode;

abstract class ZoneType
{
    // Last update: Jan 2nd, 2022

    const URBAN = 'U';
    const RURAL = 'R';

    protected static $map = [
        self::URBAN => 'Urbano',
        self::RURAL => 'Rural',
    ];

    public static function getKeyFromName(string $name): ?string
    {
        $map = self::$map;
        array_map('strtolower', $map);
        $inverted = array_flip($map);

        if (array_key_exists($name, $inverted)) {
            return $inverted[$name];
        }

        return null;
    }

    public static function getName($id): string
    {
        if (!self::exists($id)) {
            throw new \RuntimeException(sprintf('ZoneType "%s" is not registered', $id));
        }

        return self::$map[$id];
    }

    public static function exists($id): bool
    {
        return array_key_exists($id, self::$map);
    }
}