<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\PrintingPress;
use App\Models\Roles;
use App\Models\StoreBook;
use App\Models\Subjects;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class adminController extends Controller
{



    function printingPressIndex()
    {
        return view('adminPanel.printing_press.index');
    }

    function printingPressStore(Request $request)
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

    function printingPressTableData()
    {
        $printingPresses = PrintingPress::all();
        return response()->json($printingPresses);
    }

    function printingPressEdit($id)
    {
        $findData = PrintingPress::find($id);
        return $findData;
    }

    public function printingPressUpdate(Request $request, $id)
    {

        $printingPress = PrintingPress::find($id);
        $printingPress->name = $request->name;
        $printingPress->address = $request->address;
        $printingPress->save();

        return response()->json(['success' => true, 'message' => 'Printing press updated successfully']);
    }

    public function printingPressDestroy($id)
    {
        $printingPress = PrintingPress::findOrFail($id);
        $printingPress->delete();

        return response()->json(['success' => 'Printing press deleted successfully.']);
    }












    function bookStorageIndex()
    {
        $printingPress = PrintingPress::all();
        $classes = Classes::all();
        $subjects = Subjects::all();
        return view('adminPanel.store_book.index', compact('printingPress','classes','subjects'));
    }

    public function getSubjectsByClass(Request $request, $classId)
    {
        $subjects = Subjects::where('class_id', $classId)->get();
        return response()->json($subjects);
    }

    function bookStorageTable()
    {
        $bookStorages = StoreBook::with('printingPress')->with('subject')->with('classes')->orderBy('id', 'desc')->get();
        // return response()->json($bookStorages);
        $html = view('adminPanel.store_book.book_storage_table', compact('bookStorages'))->render();
        return response()->json(['html' => $html]);
    }

    function bookStorageStore(Request $request)
    {
        $request->validate([
            'printingPressID' => 'required|string|max:255',
            'classID' => 'required|',
            'subjectID' => 'required|string',
            'total_book' => 'required|numeric',
        ]);

        $storeBook = new StoreBook();
        $storeBook->printing_press_id = $request->input('printingPressID');
        $storeBook->class_id = $request->input('classID');
        $storeBook->subject_id = $request->input('subjectID');
        $storeBook->total_book = $request->input('total_book');
        $storeBook->save();

        return response()->json(['message' => 'Book Store successfully']);
    }




    public function bookStorageEdit($id)
    {
        $storeBook = StoreBook::find($id);
        return response()->json($storeBook);
    }

    public function bookStorageUpdate(Request $request, $id)
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

    public function bookStorageDestroy($id)
    {
        StoreBook::destroy($id);
        return response()->json(['message' => 'Book Deleted successfully']);
    }










    function userIndex()
    {
        $roles = Roles::all();

        return view('adminPanel.user.index',compact('roles'));
    }

    function userStore(Request $request)
    {
        $request->validate([
            'role_id' => 'required|string',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id'=>$request->role_id,
        ]);

        return response()->json(['message' => 'User Create successfully!']);
    }

    function userTableData()
    {
        $users = User::with('roles')->orderBy('id', 'desc')->get();
        $html = view('adminPanel.user.user_list', compact('users'))->render();
        return response()->json(['html' => $html]);
    }


    public function userEdit($id)
    {
        $users = User::find($id);
        return response()->json($users);
    }

    public function userUpdate(Request $request, $id)
    {
        $user = User::find($id);
        $request->validate([
            'id' => 'required',
            'role_id' => 'required',
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:8',
        ]);

        if($user->email != $request->email){
            $request->validate([
                'email' => 'required|string|email|max:255|unique:users',
            ]);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role_id = $request->role_id;
        $user->save();

        return response()->json(['message' => 'User Update successfully']);
    }

    public function userDestroy($id)
    {
        User::destroy($id);
        return response()->json(['message' => 'User Deleted successfully']);
    }










   //class methods


    function classIndex()
    {
        $classes = Classes::all();
        return view('adminPanel.classes.index',compact('classes'));
    }

    function classStore(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255|unique:classes',
        ]);

        Classes::create([
            'name' => $request->name,
        ]);

        return response()->json(['message' => 'Create successfully!']);
    }

    function classTableData()
    {
        $classes = Classes::orderBy('id', 'desc')->get();
        $html = view('adminPanel.classes.class_table', compact('classes'))->render();
        return response()->json(['html' => $html]);
    }


    public function classEdit($id)
    {
        $classes = Classes::find($id);
        return response()->json($classes);
    }

    public function classUpdate(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|string|max:255|unique:classes',
        ]);

        $classes = Classes::find($id);
        $classes->name = $request->name;
        $classes->save();

        return response()->json(['message' => 'Update successfully']);
    }

    public function classDestroy($id)
    {
        Classes::destroy($id);
        return response()->json(['message' => 'Deleted successfully']);
    }








   //subject methods



    function subjectIndex()
    {
        $classes = Classes::all();
        return view('adminPanel.subject.index',compact('classes'));
    }

    function subjectStore(Request $request)
    {

        $request->validate([
            'class_id' => 'required',
            'name' => 'required|string|max:255',
        ]);

        Subjects::create([
            'class_id'=>$request->class_id,
            'name' => $request->name,
        ]);

        return response()->json(['message' => 'Create successfully!']);
    }

    function subjectTableData()
    {
        $subjects = Subjects::orderBy('id', 'desc')->get();
        $html = view('adminPanel.subject.subject_table', compact('subjects'))->render();
        return response()->json(['html' => $html]);
    }


    public function subjectEdit($id)
    {
        $subjects = Subjects::find($id);
        return response()->json($subjects);
    }

    public function subjectUpdate(Request $request, $id)
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

    public function subjectDestroy($id)
    {
        Subjects::destroy($id);
        return response()->json(['message' => 'Deleted successfully']);
    }



}
