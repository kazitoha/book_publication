<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\BookStorage;
use App\Models\Classes;
use Illuminate\Http\Request;
use App\Models\PrintingPress;
use App\Models\Subjects;
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

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        // Initialize the query with relationships and date filtering
        $details_about_printing_press = BookStorage::with(['printingPress', 'subject', 'classes'])
            ->whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->orderBy('id', 'desc');

        // Add the printing_press_id condition only if it's provided in the request
        if ($request->printing_press_id) {
            $details_about_printing_press->where('printing_press_id', $request->printing_press_id);
        }

        // Execute the query to get the filtered results
        $bookStorages = $details_about_printing_press->get();


        // Execute the query and map the results


        return view('adminPanel.printing_press_all_information.basic_data', compact('all_printing_press', 'bookStorages', 'start_date', 'end_date'));
    }

    public function getThisDetailsByMonth(Request $request)
    {
        $request->validate([
            'book_storage_id' => 'nullable|integer',
            'printing_press_id' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $start_date = $request->start_date;
        $end_date = $request->end_date;


        // Initialize the query with relationships and date filtering
        $details_about_printing_press = BookStorage::with(['printingPress', 'subject', 'classes'])
            ->where('printing_press_id', $request->printing_press_id)
            ->whereDate('created_at', '>=', $request->start_date)
            ->whereDate('created_at', '<=', $request->end_date)
            ->orderBy('id', 'desc');

        // Add the printing_press_id condition only if it's provided in the request
        if ($request->book_storage_id) {
            $details_about_printing_press->where('id', $request->book_storage_id);
        }

        // Execute the query to get the filtered results
        $details_about_printing_press = $details_about_printing_press->get();

        $details_about_printing_press = transformBookStorageData($details_about_printing_press);


        // dd($details_about_printing_press[0]->printingPress->name);


        // // Return the view with both the specific book storage and the filtered list
        return view('adminPanel.printing_press_all_information.details', compact('details_about_printing_press', 'start_date', 'end_date'));
    }
}
