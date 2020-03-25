<?php

namespace App\Enums;

class TopupStatus{
    public const PENDING ="pending";
    public const SUCCESS ="success";
    public const FAILED ="failed";
    
    public static function getAllKeys() {
        return [
            self::PENDING,
            self::SUCCESS,
            self::FAILED
        ];
    }
}