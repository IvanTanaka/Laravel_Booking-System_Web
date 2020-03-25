<?php

namespace App\Enums;

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