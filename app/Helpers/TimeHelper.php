<?php

namespace App\Helpers;

use Carbon\Carbon;

class TimeHelper
{
    public static function transformStringToCarbon(string | Carbon $time, string $format): string
    {
        if ($time instanceof Carbon) {
            return $time->format($format);
        }

        return Carbon::parse($time)->format($format);
    }
}
