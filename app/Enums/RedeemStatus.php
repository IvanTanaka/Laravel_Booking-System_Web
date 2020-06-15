<?php

namespace App\Enums;

class RedeemStatus{
    public const WAITING ="waiting";
    public const ACCEPTED ="accepted";
    public const REJECTED ="rejected";
    
    public static function getAllKeys() {
        return [
            self::WAITING,
            self::ACCEPTED,
            self::REJECTED
        ];
    }
}