<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function formatDate($date, $format = 'Y-m-d'): string
    {
        return Carbon::parse($date)->format($format);
    }
}
