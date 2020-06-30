<?php

namespace App\Enums;

class RedeemStatus{
    public const WAITING ="waiting"; //First status when redeem is created;
    public const ACCEPTED ="accepted"; //If Admin accepted the redeem;
    public const FINISHED ="finished"; //If Admin transfer the money;
    public const REJECTED ="rejected"; //If Admin rejected the redeem
    public const CANCELED ="canceled"; //If Owner canceled the redeem before the admin process;
    
    public static function getAllKeys() {
        return [
            self::WAITING,
            self::ACCEPTED,
            self::FINISHED,
            self::REJECTED,
            self::CANCELED
        ];
    }
}