<?php

use App\Models\Subjects;

if (!function_exists('format_date')) {
    /**
     * Format a date to a human-readable form.
     *
     * @param  string  $date
     * @return string
     */
    function format_date($date)
    {
        return \Carbon\Carbon::parse($date)->format('F d, Y');
    }

    function convertToBangla($number)
    {
        $fmt = new \NumberFormatter('bn_BD', \NumberFormatter::DECIMAL);
        $banglaCount = $fmt->format($number);
        return $banglaCount;

    }
}
