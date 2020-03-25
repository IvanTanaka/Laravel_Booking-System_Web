<?php

namespace App\Enums;

class OrderStatus{
    public const WAITING ="waiting";
    public const ACCEPTED ="accepted";
    public const FINISHED ="finished";
    public const CANCELED ="canceled";
    
    public static function getAllKeys() {
        return [
            self::WAITING,
            self::ACCEPTED,
            self::FINISHED,
            self::CANCELED
        ];
    }
}