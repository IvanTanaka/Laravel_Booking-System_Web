<?php

namespace App\Enums;

class OrderStatus{
    public const WAITING ="waiting";  //Customer making order, waiting for Cashier response.
    public const NO_RESPONSE = "no_response"; //Customer making order, Cashier not giving any response till time limit.
    public const ACCEPTED ="accepted"; //Customer making order, Cashier accepted customer order.
    public const FINISHED ="finished"; //Order were finished by Customer. Payment accepted.
    public const CANCELED ="canceled"; //Accepted order were Canceled by Customer.
    public const DENIED ="denied"; // Customer making order, Cashier denied customer order.
    
    public static function getAllKeys() {
        return [
            self::WAITING,
            self::NO_RESPONSE,
            self::ACCEPTED,
            self::FINISHED,
            self::CANCELED,
            self::DENIED
        ];
    }
}