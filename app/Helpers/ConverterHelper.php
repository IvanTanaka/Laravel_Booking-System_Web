<?php

namespace App\Helpers;

function convertToTime($timeString)
{
    return date("H:i:s", strtotime($timeString));
}