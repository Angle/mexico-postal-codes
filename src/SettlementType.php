<?php

namespace Angle\Mexico\PostalCode;

abstract class SettlementType
{
    // Last update: Jan 2nd, 2022

    const AEROPUERTO            = 1;
    const BARRIO                = 2;
    const CAMPAMENTO            = 4;
    const COLONIA               = 9;
    const CONDOMINIO            = 10;
    const CONGREGACION          = 11;
    const CONJUNTO_HABITACIONAL = 12;
    const EJIDO                 = 15;
    const ESTACION              = 16;
    const EQUIPAMIENTO          = 17;
    const EX_HACIENDA           = 18;
    const FINCA                 = 20;
    const FRACCIONAMIENTO       = 21;
    const GRANJA                = 23;
    const HACIENDA              = 24;
    const PARQUE_INDUSTRIAL     = 26;
    const POBLADO_COMUNAL       = 27;
    const PUEBLO                = 28;
    const RANCHERIA             = 29;
    const RESIDENCIAL           = 30;
    const UNIDAD_HABITACIONAL   = 31;
    const VILLA                 = 32;
    const ZONA_COMERCIAL        = 33;
    const ZONA_FEDERAL          = 34;
    const ZONA_INDUSTRIAL       = 37;
    const PUERTO                = 40;
    const PARAJE                = 45;
    const ZONA_NAVAL            = 46;
    const ZONA_MILITAR          = 47;
    const RANCHO                = 48;

    protected static $map = [
        self::AEROPUERTO => 'Aeropuerto',
        self::BARRIO => 'Barrio',
        self::CAMPAMENTO => 'Campamento',
        self::COLONIA => 'Colonia',
        self::CONDOMINIO => 'Condominio',
        self::CONGREGACION => 'Congregación',
        self::CONJUNTO_HABITACIONAL => 'Conjunto Habitacional',
        self::EJIDO => 'Ejido',
        self::ESTACION => 'Estación',
        self::EQUIPAMIENTO => 'Equipamiento',
        self::EX_HACIENDA => 'Ex-hacienda',
        self::FINCA => 'Finca',
        self::FRACCIONAMIENTO => 'Fraccionamiento',
        self::GRANJA => 'Granja',
        self::HACIENDA => 'Hacienda',
        self::PARQUE_INDUSTRIAL => 'Parque Industrial',
        self::POBLADO_COMUNAL => 'Poblado Comunal',
        self::PUEBLO => 'Pueblo',
        self::RANCHERIA => 'Ranchería',
        self::RESIDENCIAL => 'Residencial',
        self::UNIDAD_HABITACIONAL => 'Unidad Habitacional',
        self::VILLA => 'Villa',
        self::ZONA_COMERCIAL => 'Zona Comercial',
        self::ZONA_FEDERAL => 'Zona Federal',
        self::ZONA_INDUSTRIAL => 'Zona Industrial',
        self::PUERTO => 'Puerto',
        self::PARAJE => 'Paraje',
        self::ZONA_NAVAL => 'Zona Naval',
        self::ZONA_MILITAR => 'Zona Militar',
        self::RANCHO => 'Rancho',
    ];


    public static function getName($id): string
    {
        if (!self::exists($id)) {
            throw new \RuntimeException(sprintf('SettlementType "%s" is not registered', $id));
        }

        return self::$map[$id];
    }

    public static function exists($id): bool
    {
        return array_key_exists($id, self::$map);
    }
}