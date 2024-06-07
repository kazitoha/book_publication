<?php

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
}
