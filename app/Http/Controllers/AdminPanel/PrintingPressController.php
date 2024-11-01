<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\BookStorage;
use App\Models\Classes;
use Illuminate\Http\Request;
use App\Models\PrintingPress;
use App\Models\Subjects;
use Illuminate\Support\Facades\DB;
use Svg\Tag\Rect;

class PrintingPressController extends Controller
{
    function Index()
    {
        return view('adminPanel.printing_press.index');
    }

    function Store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        $printingPress = new PrintingPress();
        $printingPress->name = $request->input('name');
        $printingPress->address = $request->input('address');
        $printingPress->save();

        return response()->json(['message' => 'Printing Press added successfully']);
    }

    function Show()
    {
        $printingPresses = PrintingPress::all();
        return response()->json($printingPresses);
    }

    function Edit($id)
    {
        $findData = PrintingPress::find($id);
        return $findData;
    }

    public function Update(Request $request, $id)
    {

        $printingPress = PrintingPress::find($id);
        $printingPress->name = $request->name;
        $printingPress->address = $request->address;
        $printingPress->save();

        return response()->json(['success' => true, 'message' => 'Printing press updated successfully']);
    }

    public function Destroy($id)
    {
        $printingPress = PrintingPress::findOrFail($id);
        $printingPress->delete();

        return response()->json(['success' => 'Printing press deleted successfully.']);
    }


    public function PrintingPressAllInformation()
    {
        $all_printing_press = PrintingPress::all();
        return view('adminPanel.printing_press_all_information.basic_data', compact('all_printing_press'));
    }

    public function PrintingPressFilterInformation(Request $request)
    {
        $request->validate([
            'printing_press_id' => 'nullable|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Fetch all printing presses for the dropdown
        $all_printing_press = PrintingPress::all();

        $printing_press_id = $request->printing_press_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $bookStorages = BookStorage::with('printingPress')
            ->when($printing_press_id, function ($query, $printing_press_id) {
                return $query->where('printing_press_id', $printing_press_id);
            })
            ->whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->orderBy('batch', 'desc')
            ->paginate(40);


        dd($bookStorages);

        return view('adminPanel.printing_press_all_information.basic_data', compact(
            'all_printing_press',
            'printing_press_id',
            'bookStorages',
            'start_date',
            'end_date'
        ));
    }


    public function getThisDetailsByMonth(Request $request)
    {
        $request->validate([
            'print_type' => 'required|in:multiple,single',
            'book_storage_id' => 'nullable|integer',
            'printing_press_id' => 'nullable|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);


        $print_type = $request->print_type;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        // Initialize the query with relationships and date filtering
        $details_about_printing_press = BookStorage::with(['printingPress', 'subject', 'classes'])
            ->whereDate('created_at', '>=', $request->start_date)
            ->whereDate('created_at', '<=', $request->end_date)
            ->orderBy('id', 'desc');

        // Add the printing_press_id condition only if it's provided in the request
        if ($request->book_storage_id) {
            $details_about_printing_press->where('id', $request->book_storage_id);
        }
        if ($request->printing_press_id) {
            $details_about_printing_press->where('printing_press_id', $request->printing_press_id);
        }
        // Execute the query to get the filtered results
        $details_about_printing_press = $details_about_printing_press->get();

        $details_about_printing_press = transformBookStorageData($details_about_printing_press);


        return view('adminPanel.printing_press_all_information.print_or_download', compact('details_about_printing_press', 'print_type', 'start_date', 'end_date'));
    }

    public function searchFromFilteredData(Request $request)
    {
        $request->validate([
            'search' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Fetch book storage records based on some criteria (e.g., a specific date range, etc.)
        $bookStorages = BookStorage::with('printingPress')
            ->whereDate('created_at', '>=', $request->start_date)
            ->whereDate('created_at', '<=', $request->end_date)
            ->where('class_id', 'like', '%"' . $request->search . '"%')
            ->orWhere('subject_id', 'like', '%"' . $request->search . '"%')
            ->get();




        $classIds = [];

        foreach ($bookStorages as $bookStorage) {
            // Decode the class_id JSON string into an array
            $classIds = array_merge($classIds, json_decode($bookStorage->class_id, true));
        }


        $count = DB::table('book_storage')
            ->whereRaw('JSON_CONTAINS(class_id, ?)', ['"2"'])
            ->count();


        echo "Total occurrences of class ID 1: " . $count;



        dd($count);

        // return view('adminPanel.search_results', compact('bookStorages', 'start_date', 'end_date'));
    }
}
