<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\BookStorage;
use Illuminate\Http\Request;
use App\Models\Sell;
use App\Models\Classes;
use App\Models\PrintingPress;
use App\Models\Roles;
use App\Models\Subjects;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;


class BookStorageController extends Controller
{
    function Index()
    {
        $printingPress = PrintingPress::all();
        $classes = Classes::all();
        $subjects = Subjects::all();
        return view('adminPanel.store_book.index', compact('printingPress', 'classes', 'subjects'));
    }


    public function Show()
    {
        $bookStorages = BookStorage::with('printingPress', 'classes')
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($bookStorage) {
                // Decode JSON fields
                $classIds = json_decode($bookStorage->class_id, true);
                $subjectIds = json_decode($bookStorage->subject_id, true);
                $totalUnits = json_decode($bookStorage->total_unit, true);

                // Retrieve subject names
                $subjects = Subjects::whereIn('id', $subjectIds)->pluck('name')->toArray();
                //class name also
                $classes = Classes::whereIn('id', $classIds)->pluck('name')->toArray();


                // Assign subject names and total units
                $bookStorage->classsNames = $classes;
                $bookStorage->subjectNames = $subjects;
                $bookStorage->totalUnits = $totalUnits;

                return $bookStorage;
            });

        $html = view('adminPanel.store_book.book_storage_table', compact('bookStorages'))->render();
        return response()->json(['html' => $html]);
    }



    function Store(Request $request)
    {

        $request->validate([
            'printingPressID' => 'required',
            'classID.*' => 'required|',
            'subjectID.*' => 'required',
            'unit_price.*' => 'required',
            'total_unit.*' => 'required',
            'paid_amount' => 'nullable',
            'unpaid_amount' => 'required',
        ]);

        // Retrieve subject details
        $subject_details = Subjects::whereIn('id', $request->input('subjectID'))->get();

        // Prepare arrays for calculations
        $classIDs = $request->input('classID');
        $subjectIDs = $request->input('subjectID');
        $unitPrices = $request->input('unit_price');
        $totalUnits = $request->input('total_unit');


        // Save the sale
        $bookStorage = new BookStorage();
        $bookStorage->printing_press_id = $request->input('printingPressID');
        $bookStorage->class_id = json_encode($classIDs);
        $bookStorage->subject_id = json_encode($subjectIDs);
        $bookStorage->unit_price = json_encode($unitPrices);
        $bookStorage->total_unit = json_encode($totalUnits);
        $bookStorage->paid_amount = $request->input('paid_amount');
        $bookStorage->unpaid_amount = $request->input('unpaid_amount');
        $bookStorage->save();


        $subject_details = Subjects::whereIn('id', $request->input('subjectID'))->get();

        foreach ($subject_details as $subject_detail) {
            $subjectIndex = array_search($subject_detail->id, $subjectIDs);
            // Update the subject's total unit
            $subject_detail->total_unit += $totalUnits[$subjectIndex];
            $subject_detail->save();
        }






        // if ($subject_detail->null) {
        //     $subject_detail->update([
        //         'total_unit' => $request->input('total_unit'),
        //     ]);
        // } else {
        //     $total_books_in_this_subject = $subject_detail->total_unit + $request->input('total_unit');
        //     $subject_detail->update([
        //         'total_unit' => $total_books_in_this_subject,
        //     ]);
        // }

        //  $printing_press_amount = ($request->unit_price * $request->total_unit) - $request->paid_amount;


        return response()->json(['message' => 'Book Store successfully']);
    }




    public function Edit($id)
    {
        $storeBook = BookStorage::find($id);
        return response()->json($storeBook);
    }

    public function Update(Request $request, $id)
    {
        $request->validate([
            'printingPressID' => 'required|string|max:255',
            'classID' => 'required|',
            'subjectID' => 'required|string',
            'total_book' => 'required|numeric',
        ]);

        $storeBook = BookStorage::find($id);
        $storeBook->printing_press_id = $request->input('printingPressID');
        $storeBook->class_id = $request->input('classID');
        $storeBook->subject_id = $request->input('subjectID');
        $storeBook->total_book = $request->input('total_book');
        $storeBook->save();

        return response()->json(['message' => 'Book Update successfully']);
    }


    public function Destroy($id)
    {
        BookStorage::destroy($id);
        return response()->json(['message' => 'Book Deleted successfully']);
    }

    public function Invoice($id)
    {

        $book_storage = BookStorage::with('printingPress', 'subject', 'classes')->find($id);

        if (!$book_storage) {
            return back()->with('error', 'something went worng');
        }

        $data = [
            'id' => $book_storage->id,
            'printing_press_name' => $book_storage->printingPress->name,
            'address' => $book_storage->printingPress->address,
            'class_name' => $book_storage->classes->name,
            'subject_name' => $book_storage->subject->name,
            'unit_price' => $book_storage->unit_price,
            'total_unit' => $book_storage->total_unit,
            'created' => $book_storage->created_at->format(' F j, Y'),
        ];

        // Debug: Log data to ensure it's correct

        $pdf = PDF::setPaper('a4', 'portrait')->loadView('adminPanel.store_book.invoice', $data);

        $pdf_name = $book_storage->printingPress->name . '-' . $book_storage->created_at->format(' F j, Y') . ".pdf";
        return $pdf->download($pdf_name);
    }
}
