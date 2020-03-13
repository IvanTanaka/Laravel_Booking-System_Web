<?php

namespace App\Enums;

/**
* @method static self $FOOD()
* @method static self $BARBER()
* @method static self $KARAOKE()
* @method static self $SPORT()
* @method static self getAllKeys()
* @method static self getAll()
*/

class ServiceType{
    public const FOOD = 
    [
        "type"=> "food",
        "text"=> "Restaurant"
    ];
    public const KARAOKE =
    [
        "type"=> "karaoke",
        "text"=> "Karaoke Places"
    ];
    public const BARBER =
    [
        "type"=> "barber",
        "text"=> "Barber Shop"
    ];
    public const SPORT =
    [
        "type"=> "sport",
        "text"=> "Sport Field"
    ];
    
    
    public static function getAllKeys() {
        return[
            self::FOOD["type"],
            self::KARAOKE["type"],
            self::BARBER["type"],
            self::SPORT["type"]
        ];
    }
    
    public const getAll = [
        self::FOOD,
        self::KARAOKE,
        self::BARBER,
        self::SPORT
    ];
    
}


