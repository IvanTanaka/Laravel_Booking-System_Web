<?php

namespace App\Helpers;
use Webpatser\Uuid\Uuid;

function generateUuid()
{
    return Uuid::generate()->string;
}