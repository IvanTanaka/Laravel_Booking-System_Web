<?php

namespace App\Enums;

class FoodCategory{
    public const SEA_FOOD ="sea_food";
    public const FAST_FOOD ="fast_food";
    public const SALAD ="salad";
    public const DRINKS ="drinks";
    
    public static function getAllKeys() {
        return [
            self::SEA_FOOD,
            self::FAST_FOOD,
            self::SALAD,
            self::DRINKS
        ];
    }
}