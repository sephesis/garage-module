<?php

namespace ORC\Garage;

class Config
{
    const GARAGE_IBLOCK = 41;

    const GARAGE_CATEGORIES_NAME = [
        'gruz' => 'gruzovye_avtomobili',
        'bus' => 'avtobusy',
        'selhoz' => 'selhoztehnika',
        'spec' => 'spetstehnika',
    ];

    const TYPEAUTO_IDS = [
        "2", "3", "4", "5",
    ];

    public static function get($paramName, $defaultValue = '') {
        if (isset(self::GARAGE_CATEGORIES_NAME[$paramName])) {
            return self::GARAGE_CATEGORIES_NAME[$paramName];
        } else {
            return $defaultValue;
        }
    }
}