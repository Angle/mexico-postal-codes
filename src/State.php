<?php

namespace Angle\Mexico\PostalCode;

abstract class State
{
    // Last update: Jan 2nd, 2022

    // ISO Codes: ISO 3166/MX

    const AGUASCALIENTES        = 1;
    const BAJA_CALIFORNIA       = 2;
    const BAJA_CALIFORNIA_SUR   = 3;
    const CAMPECHE              = 4;
    const COAHUILA              = 5;
    const COLIMA                = 6;
    const CHIAPAS               = 7;
    const CHIHUAHUA             = 8;
    const CIUDAD_DE_MEXICO      = 9;
    const DURANGO               = 10;
    const GUANAJUATO            = 11;
    const GUERRERO              = 12;
    const HIDALGO               = 13;
    const JALISCO               = 14;
    const ESTADO_DE_MEXICO      = 15;
    const MICHOACAN             = 16;
    const MORELOS               = 17;
    const NAYARIT               = 18;
    const NUEVO_LEON            = 19;
    const OAXACA                = 20;
    const PUEBLA                = 21;
    const QUERETARO             = 22;
    const QUINTANA_ROO          = 23;
    const SAN_LUIS_POTOSI       = 24;
    const SINALOA               = 25;
    const SONORA                = 26;
    const TABASCO               = 27;
    const TAMAULIPAS            = 28;
    const TLAXCALA              = 29;
    const VERACRUZ              = 30;
    const YUCATAN               = 31;
    const ZACATECAS             = 32;

    protected static $map = [
        self::AGUASCALIENTES        => ['iso' => 'AGU', 'name' => 'Aguascalientes'],
        self::BAJA_CALIFORNIA       => ['iso' => 'BCN', 'name' => 'Baja California'],
        self::BAJA_CALIFORNIA_SUR   => ['iso' => 'BCS', 'name' => 'Baja California Sur'],
        self::CAMPECHE              => ['iso' => 'CAM', 'name' => 'Campeche'],
        self::COAHUILA              => ['iso' => 'COA', 'name' => 'Coahuila de Zaragoza'],
        self::COLIMA                => ['iso' => 'COL', 'name' => 'Colima'],
        self::CHIAPAS               => ['iso' => 'CHP', 'name' => 'Chiapas'],
        self::CHIHUAHUA             => ['iso' => 'CHH', 'name' => 'Chihuahua'],
        self::CIUDAD_DE_MEXICO      => ['iso' => 'CMX', 'name' => 'Ciudad de México'],
        self::DURANGO               => ['iso' => 'DUR', 'name' => 'Durango'],
        self::GUANAJUATO            => ['iso' => 'GUA', 'name' => 'Guanajuato'],
        self::GUERRERO              => ['iso' => 'GRO', 'name' => 'Guerrero'],
        self::HIDALGO               => ['iso' => 'HID', 'name' => 'Hidalgo'],
        self::JALISCO               => ['iso' => 'JAL', 'name' => 'Jalisco'],
        self::ESTADO_DE_MEXICO      => ['iso' => 'MEX', 'name' => 'México'],
        self::MICHOACAN             => ['iso' => 'MIC', 'name' => 'Michoacán de Ocampo'],
        self::MORELOS               => ['iso' => 'MOR', 'name' => 'Morelos'],
        self::NAYARIT               => ['iso' => 'NAY', 'name' => 'Nayarit'],
        self::NUEVO_LEON            => ['iso' => 'NLE', 'name' => 'Nuevo León'],
        self::OAXACA                => ['iso' => 'OAX', 'name' => 'Oaxaca'],
        self::PUEBLA                => ['iso' => 'PUE', 'name' => 'Puebla'],
        self::QUERETARO             => ['iso' => 'QUE', 'name' => 'Querétaro'],
        self::QUINTANA_ROO          => ['iso' => 'ROO', 'name' => 'Quintana Roo'],
        self::SAN_LUIS_POTOSI       => ['iso' => 'SLP', 'name' => 'San Luis Potosí'],
        self::SINALOA               => ['iso' => 'SIN', 'name' => 'Sinaloa'],
        self::SONORA                => ['iso' => 'SON', 'name' => 'Sonora'],
        self::TABASCO               => ['iso' => 'TAB', 'name' => 'Tabasco'],
        self::TAMAULIPAS            => ['iso' => 'TAM', 'name' => 'Tamaulipas'],
        self::TLAXCALA              => ['iso' => 'TLA', 'name' => 'Tlaxcala'],
        self::VERACRUZ              => ['iso' => 'VER', 'name' => 'Veracruz de Ignacio de la Llave'],
        self::YUCATAN               => ['iso' => 'YUC', 'name' => 'Yucatán'],
        self::ZACATECAS             => ['iso' => 'ZAC', 'name' => 'Zacatecas'],
    ];

    public static function getName($id): string
    {
        if (!self::exists($id)) {
            throw new \RuntimeException(sprintf('State "%s" is not registered', $id));
        }

        return self::$map[$id]['name'];
    }

    public static function getIso($id): string
    {
        if (!self::exists($id)) {
            throw new \RuntimeException(sprintf('State "%s" is not registered', $id));
        }

        return self::$map[$id]['iso'];
    }

    public static function getNameFromIso($iso): ?string
    {
        $iso = strtoupper($iso);

        foreach (self::$map as $key => $props) {
            if ($props['iso'] == $iso) {
                return $props['name'];
            }
        }

        return null;
        //throw new \RuntimeException(sprintf('State "%s" is not registered', $id));
    }

    public static function exists($id): bool
    {
        return array_key_exists($id, self::$map);
    }
}