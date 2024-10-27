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

if (!function_exists('convertEnglishToBangla')) {
    /**
     * Convert English numeric numbers to Bangla numerals.
     *
     * @param string|int $number
     * @return string
     */
    function convertEnglishToBangla($number)
    {
        // Mapping of English digits to Bangla digits
        $banglaDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];

        // Replace each English digit with the corresponding Bangla numeral
        return str_replace(range(0, 9), $banglaDigits, (string) $number);
    }
}
