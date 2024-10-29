<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PrintingPress;


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





}
