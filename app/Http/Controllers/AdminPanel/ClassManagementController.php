<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Classes;


class ClassManagementController extends Controller
{
   
    function Index()
    {
        $classes = Classes::all();
        return view('adminPanel.classes.index', compact('classes'));
    }

    function Store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255|unique:classes',
        ]);

        Classes::create([
            'name' => $request->name,
        ]);

        return response()->json(['message' => 'Create successfully!']);
    }

    function Show()
    {
        $classes = Classes::orderBy('id', 'desc')->get();
        $html = view('adminPanel.classes.class_table', compact('classes'))->render();
        return response()->json(['html' => $html]);
    }


    public function Edit($id)
    {
        $classes = Classes::find($id);
        return response()->json($classes);
    }

    public function Update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|string|max:255|unique:classes',
        ]);

        $classes = Classes::find($id);
        $classes->name = $request->name;
        $classes->save();

        return response()->json(['message' => 'Update successfully']);
    }

    public function Destroy($id)
    {
        Classes::destroy($id);
        return response()->json(['message' => 'Deleted successfully']);
    }
}
