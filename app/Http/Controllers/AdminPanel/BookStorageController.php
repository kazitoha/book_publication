<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\BookStorage;
use App\Models\PrintingPress;
use App\Models\Classes;
use App\Models\Subjects;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookStorageController extends Controller
{
    public function Index()
    {
        $printingPress = PrintingPress::all();
        $classes = Classes::all();
        $subjects = Subjects::all();
        return view('adminPanel.store_book.index', compact('printingPress', 'classes', 'subjects'));
    }

    public function show()
    {

        $bookStorages = BookStorage::select(
            'batch',
            DB::raw('count(*) as total_records'),
            DB::raw('sum(unit_price) as total_price'),
            DB::raw('GROUP_CONCAT(DISTINCT class_id) as class_ids'),
            DB::raw('GROUP_CONCAT(DISTINCT subject_id) as subject_ids')
        )
            ->groupBy('batch')
            ->get();

        $html = view('adminPanel.store_book.book_storage_table', compact('bookStorages'))->render();
        return response()->json(['html' => $html]);
    }



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

        $batch = BookStorage::latest('batch')->first();

        $lastBookStorage = BookStorage::latest('batch')->first();
        $batch = empty($lastBookStorage) ? 1 : $lastBookStorage->batch + 1;

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


    public function Edit($id)
    {
        $storeBook = BookStorage::with('details')->find($id);
        return response()->json($storeBook);
    }

    public function Update(Request $request, $id)
    {
        $request->validate([
            'printingPressID' => 'required',
            'classID.*' => 'required',
            'subjectID.*' => 'required',
            'unit_price.*' => 'required|numeric',
            'total_unit.*' => 'required|integer',
            'paid_amount' => 'nullable|numeric',
            'unpaid_amount' => 'required|numeric',
        ]);

        $bookStorage = BookStorage::findOrFail($id);
        $bookStorage->update([
            'printing_press_id' => $request->input('printingPressID'),
            'paid_amount' => $request->input('paid_amount'),
            'unpaid_amount' => $request->input('unpaid_amount')
        ]);

        BookStorageDetail::where('book_storage_id', $id)->delete();

        $classIDs = $request->input('classID');
        $subjectIDs = $request->input('subjectID');
        $unitPrices = $request->input('unit_price');
        $totalUnits = $request->input('total_unit');

        foreach ($subjectIDs as $index => $subjectID) {
            BookStorageDetail::create([
                'book_storage_id' => $bookStorage->id,
                'class_id' => $classIDs[$index],
                'subject_id' => $subjectID,
                'unit_price' => $unitPrices[$index],
                'total_unit' => $totalUnits[$index],
            ]);
        }

        return response()->json(['message' => 'Book updated successfully']);
    }

    public function Destroy($id)
    {
        BookStorage::destroy($id);
        return response()->json(['message' => 'Book deleted successfully']);
    }

    public function Invoice($id)
    {
        $bookStorage = BookStorage::with(['printingPress', 'details.class', 'details.subject'])->find($id);

        if (!$bookStorage) {
            return back()->with('error', 'Something went wrong');
        }

        $data = [
            'id' => $bookStorage->id,
            'printing_press_name' => $bookStorage->printingPress->name,
            'address' => $bookStorage->printingPress->address,
            'details' => $bookStorage->details,
            'created' => $bookStorage->created_at->format('F j, Y'),
        ];

        $pdf = PDF::setPaper('a4', 'portrait')->loadView('adminPanel.store_book.invoice', $data);
        $pdf_name = $bookStorage->printingPress->name . '-' . $bookStorage->created_at->format('F j, Y') . ".pdf";
        return $pdf->download($pdf_name);
    }
}
