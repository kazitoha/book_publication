<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\BookStorage;
use App\Models\Classes;
use Illuminate\Http\Request;
use App\Models\PrintingPress;
use App\Models\Subjects;

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
        // Initialize the query
        $query = BookStorage::with('printingPress', 'classes')
            ->whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->orderBy('id', 'desc');

        // Add printing_press_id condition only if it is provided
        if ($request->printing_press_id) {
            $query->where('printing_press_id', $request->printing_press_id);
        }

        // Execute the query and map the results
        $bookStorages = $query->get()->map(function ($bookStorage) {
            // Decode JSON fields
            $classIds = json_decode($bookStorage->class_id, true);
            $subjectIds = json_decode($bookStorage->subject_id, true);
            $totalUnits = json_decode($bookStorage->total_unit, true);

            // Retrieve subject names
            $subjects = Subjects::whereIn('id', $subjectIds)->pluck('name')->toArray();
            // Retrieve class names
            $classes = Classes::whereIn('id', $classIds)->pluck('name')->toArray();

            // Assign subject names and total units
            $bookStorage->classsNames = $classes;
            $bookStorage->subjectNames = $subjects;

            // dd($bookStorage);

            return $bookStorage;
        });

        return view('adminPanel.printing_press_all_information.basic_data', compact('all_printing_press', 'bookStorages', 'start_date', 'end_date'));
    }

    public function printPressInfomation($printingPressInfo, $start_date, $end_date)
    {
        // Fetch the specific record or fail
        $bookStorage = BookStorage::with('printingPress', 'classes')
            ->findOrFail($printingPressInfo);

        // Decode JSON fields for the selected bookStorage
        $classIds = json_decode($bookStorage->class_id, true);
        $subjectIds = json_decode($bookStorage->subject_id, true);
        $totalUnits = json_decode($bookStorage->total_unit, true);

        // Retrieve subject names
        $subjects = Subjects::whereIn('id', $subjectIds)->pluck('name')->toArray();
        // Retrieve class names
        $classes = Classes::whereIn('id', $classIds)->pluck('name')->toArray();

        // Assign subject names and total units to the bookStorage object
        $bookStorage->classsNames = $classes;
        $bookStorage->subjectNames = $subjects;
        $bookStorage->totalUnits = $totalUnits;

        // Query for book storages within the specified date range
        $bookStoragesInRange = BookStorage::with('printingPress', 'classes')
            ->whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($book) {
                // Decode JSON fields
                $classIds = json_decode($book->class_id, true);
                $subjectIds = json_decode($book->subject_id, true);
                $totalUnits = json_decode($book->total_unit, true);

                // Retrieve subject names
                $subjects = Subjects::whereIn('id', $subjectIds)->pluck('name')->toArray();
                // Retrieve class names
                $classes = Classes::whereIn('id', $classIds)->pluck('name')->toArray();

                // Assign subject names and total units
                $book->classsNames = $classes;
                $book->subjectNames = $subjects;
                $book->totalUnits = $totalUnits;

                return $book;
            });

        // Return the view with both the specific book storage and the filtered list
        return view('adminPanel.printing_press_all_information.details', compact('bookStorage', 'bookStoragesInRange', 'start_date', 'end_date'));
    }
}
