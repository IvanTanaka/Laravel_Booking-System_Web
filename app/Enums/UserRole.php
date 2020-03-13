<?php

namespace App\Enums;

/**
 * @method static self OWNER()
 * @method static self STORE()
 * @method static self CUSTOMER()
 * @method static self getAllKeys()
 */

class UserRole{
    public const OWNER ="owner";
    public const STORE ="store";
    public const CUSTOMER ="customer";

    public const getAllKeys = [
        self::OWNER,
        self::STORE,
        self::CUSTOMER
    ];
}