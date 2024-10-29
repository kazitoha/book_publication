<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sell;
use App\Models\Classes;
use App\Models\PrintingPress;
use App\Models\Roles;
use App\Models\StoreBook;
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


    function Show()
    {
        $bookStorages = StoreBook::with('printingPress', 'subject', 'classes')->orderBy('id', 'desc')->get();
    
      
    
        $html = view('adminPanel.store_book.book_storage_table', compact('bookStorages'))->render();
        return response()->json(['html' => $html]);
    }
    

    function Store(Request $request)
    {

        $request->validate([
            'printingPressID' => 'required|string|max:255',
            'classID' => 'required|',
            'subjectID' => 'required|string',
            'unit_price' => 'required|string',
            'total_unit' => 'required|numeric',
            'paid_amount' => 'nullable|string',
            'unpaid_amount' => 'required|string',
        ]);

        $storeBook = new StoreBook();
        $storeBook->printing_press_id = $request->input('printingPressID');
        $storeBook->class_id = $request->input('classID');
        $storeBook->subject_id = $request->input('subjectID');
        $storeBook->unit_price = $request->input('unit_price');
        $storeBook->total_unit = $request->input('total_unit');
        $storeBook->paid_amount = $request->input('paid_amount');
        $storeBook->unpaid_amount = $request->input('unpaid_amount');
        $storeBook->save();

        $subject_detail = Subjects::find($request->input('subjectID'));

        if ($subject_detail->null) {
            $subject_detail->update([
                'total_unit' => $request->input('total_unit'),
            ]);
        } else {
            $total_books_in_this_subject = $subject_detail->total_unit + $request->input('total_unit');
            $subject_detail->update([
                'total_unit' => $total_books_in_this_subject,
            ]);
        }

        //  $printing_press_amount = ($request->unit_price * $request->total_unit) - $request->paid_amount;


        return response()->json(['message' => 'Book Store successfully']);
    }




    public function Edit($id)
    {
        $storeBook = StoreBook::find($id);
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

        $storeBook = StoreBook::find($id);
        $storeBook->printing_press_id = $request->input('printingPressID');
        $storeBook->class_id = $request->input('classID');
        $storeBook->subject_id = $request->input('subjectID');
        $storeBook->total_book = $request->input('total_book');
        $storeBook->save();

        return response()->json(['message' => 'Book Update successfully']);
    }


    public function Destroy($id)
    {
        StoreBook::destroy($id);
        return response()->json(['message' => 'Book Deleted successfully']);
    }

    public function Invoice($id)
    {

        $book_storage = StoreBook::with('printingPress', 'subject', 'classes')->find($id);

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
