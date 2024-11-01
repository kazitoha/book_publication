<?php

use App\Models\BookStorage;
use App\Models\Classes;
use App\Models\PrintingPress;
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
if (!function_exists('findPrintingPressInfo')) {
    function findPrintingPressInfo($id)
    {
        return PrintingPress::find($id); // true returns an associative array
    }
}
if (!function_exists('decodeJsonData')) {
    function decodeJsonData($data)
    {
        return json_decode($data, true); // true returns an associative array
    }
}
if (!function_exists('findSubjectInformartion')) {
    function findSubjectInformartion($id)
    {
        return Subjects::find($id);
    }
}
if (!function_exists('findClassInformartion')) {
    function findClassInformartion($id)
    {
        return Classes::find($id);
    }
}
if (!function_exists('sumJsonData')) {
    function sumJsonData($data)
    {
        // Decode JSON data into an array
        $decodedData = json_decode($data, true);

        // Check if decoding was successful and if it's an array
        if (is_array($decodedData)) {
            return array_sum($decodedData); // Sum all values in the array
        }

        return 0; // Return 0 if decoding fails or data is invalid
    }
}
if (!function_exists('transformBookStorageData')) {
    function transformBookStorageData($bookStorages)
    {
        return $bookStorages->map(function ($bookStorage) {
            $bookStorage->classNames = Classes::whereIn('id', json_decode($bookStorage->class_id, true))
                ->pluck('name')
                ->toArray();

            $bookStorage->subjectNames = Subjects::whereIn('id', json_decode($bookStorage->subject_id, true))
                ->pluck('name')
                ->toArray();

            $bookStorage->totalUnits = json_decode($bookStorage->total_unit, true);

            return $bookStorage;
        });
    }
}

function sumTotalUnitByBatchId($batchId)
{
    return BookStorage::where('batch', $batchId)->sum('total_unit');
}
