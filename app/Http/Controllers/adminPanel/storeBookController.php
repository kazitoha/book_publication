<?php

namespace App\Http\Controllers\adminPanel;

use App\Http\Controllers\Controller;
use App\Models\PrintingPress;
use App\Models\StoreBook;
use Illuminate\Http\Request;

class storeBookController extends Controller
{
    function index()
    {
        $bookStorages = StoreBook::with('printingPress')->paginate(10);
        $printingPress = PrintingPress::all();
        return view('adminPanel.store_book.index', compact('printingPress','bookStorages'));
    }

    function store(Request $request)
    {
        $request->validate([
            'printingPressID' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'total_book' => 'required|numeric|max:255',
        ]);

        $storeBook = new StoreBook();
        $storeBook->printing_press_id = $request->input('printingPressID');
        $storeBook->subject_name = $request->input('subject');
        $storeBook->total_book = $request->input('total_book');
        $storeBook->save();

        return response()->json(['message' => 'Book Store successfully']);
    }

    function showTableData()
    {
        $bookStorages = StoreBook::with('printingPress')->orderBy('id', 'desc')->get();
        $html = view('adminPanel.store_book.book_storage_table', compact('bookStorages'))->render();
        return response()->json(['html' => $html]);
    }


    public function edit($id)
    {
        $storeBook = StoreBook::find($id);
        return response()->json($storeBook);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'printingPressID' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'total_book' => 'required|numeric|max:255',
        ]);

        $storeBook = StoreBook::find($id);
        $storeBook->printing_press_id = $request->printingPressID;
        $storeBook->subject_name = $request->subject;
        $storeBook->total_book = $request->total_book;
        $storeBook->save();

        return response()->json(['message' => 'Book Update successfully']);
    }

    public function destroy($id)
    {
        StoreBook::destroy($id);
        return response()->json(['message' => 'Book Deleted successfully']);
    }
}
