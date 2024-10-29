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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class SubjectManagementController extends Controller
{
    function Index()
    {
        $classes = Classes::all();
        return view('adminPanel.subject.index', compact('classes'));
    }

    function Store(Request $request)
    {

        $request->validate([
            'class_id' => 'required',
            'name' => 'required|string|max:255',
        ]);

        Subjects::create([
            'class_id' => $request->class_id,
            'name' => $request->name,
        ]);

        return response()->json(['message' => 'Create successfully!']);
    }

    function Show()
    {
        $subjects = Subjects::orderBy('id', 'desc')->get();
        $html = view('adminPanel.subject.subject_table', compact('subjects'))->render();
        return response()->json(['html' => $html]);
    }


    public function Edit($id)
    {
        $subjects = Subjects::find($id);
        return response()->json($subjects);
    }

    public function Update(Request $request, $id)
    {

        $request->validate([
            'class_id' => 'required|string|max:255',
            'name' => 'required|string|max:255',
        ]);

        $subjects = Subjects::find($id);
        $subjects->class_id = $request->class_id;
        $subjects->name = $request->name;
        $subjects->save();

        return response()->json(['message' => 'Update successfully']);
    }

    public function Destroy($id)
    {
        Subjects::destroy($id);
        return response()->json(['message' => 'Deleted successfully']);
    }
}
