<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\BookStorage;
use App\Models\Subjects;
use Illuminate\Http\Request;

class TryNewThinksController extends Controller
{
    public function Store(Request $request)
    {
        $request->validate([
            'printingPressID' => 'required|integer',
            'classID.*' => 'required|integer',
            'subjectID.*' => 'required|integer',
            'unit_price.*' => 'required|numeric',
            'total_unit.*' => 'required|integer',
            'paid_amount' => 'nullable|numeric',
            'unpaid_amount' => 'required|numeric',
        ]);

        $classIDs = $request->input('classID');
        $subjectIDs = $request->input('subjectID');
        $unitPrices = $request->input('unit_price');
        $totalUnits = $request->input('total_unit');

        $lastBookStorage = BookStorage::latest('batch')->first();
        $batch = empty($lastBookStorage) ? 1 : $lastBookStorage->batch + 1;
        // dd($batch);
        foreach ($subjectIDs as $index => $subjectID) {

            // Validate that each index exists in all arrays to avoid undefined index errors
            if (!isset($classIDs[$index], $unitPrices[$index], $totalUnits[$index])) {
                return response()->json(['error' => 'Mismatched array lengths for subject and class data'], 400);
            }

            // Save a new BookStorage record for each subject-class combination
            $bookStorage = BookStorage::create([
                'batch' => $batch,
                'printing_press_id' => $request->input('printingPressID'),
                'class_id' => $classIDs[$index],
                'subject_id' => $subjectID,
                'unit_price' => $unitPrices[$index],
                'total_unit' => $totalUnits[$index],
                'paid_amount' => $request->input('paid_amount'),
                'unpaid_amount' => $request->input('unpaid_amount'),
            ]);

            // Update the total unit count for the subject
            $subject = Subjects::find($subjectID);
            if ($subject) {
                $subject->increment('total_unit', $totalUnits[$index]);
            } else {
                return response()->json(['error' => 'Subject not found with ID ' . $subjectID], 404);
            }
        }

        return response()->json(['message' => 'Book stored successfully']);
    }

    public function show()
    {
        $batchs = BookStorage::orderBy('batch', 'desc')->get()->groupBy('batch');

        return view('try_new_thinks_table', compact('batchs'));
    }
}
