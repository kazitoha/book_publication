<?php

namespace App\Http\Controllers;

use App\Models\Sell;
use App\Models\Classes;
use App\Models\PrintingPress;
use App\Models\Roles;
use App\Models\StoreBook;
use App\Models\Subjects;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;


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
        return view('adminPanel.store_book.index', compact('printingPress', 'classes', 'subjects'));
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




    //storage alert

    public function storageAlert(){
        return view('adminPanel.storage_alert.storage_alert');
    }

    function storageTableData()
    {
        $lowStockAlert=Subjects::with('classes')->where('total_unit', '<', 10)->get();

        $html = view('adminPanel.storage_alert.alert_list', compact('lowStockAlert'))->render();
        return response()->json(['html' => $html]);
    }







    //seller management

    function createSeller()
    {
        return view('adminPanel.add_seller.add_seller');
    }

    function sellerStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        $last_insert_id = User::insertGetId([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2,
        ]);

        if ($request->hasFile('image')) {

            $path = $request->file('image')->store('seller', 'public');

            User::find($last_insert_id)->update(['image' => $path,]);
        }

        return response()->json(['message' => 'User Create successfully!']);
    }

    function sellerTableData()
    {
        $users = User::where('role_id', 2)->with('roles')->orderBy('id', 'desc')->get();
        $html = view('adminPanel.add_seller.seller_list', compact('users'))->render();
        return response()->json(['html' => $html]);
    }


    public function sellerEdit($id)
    {
        $users = User::find($id);
        return response()->json($users);
    }

    public function sellerUpdate(Request $request, $id)
    {


        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'password' => 'nullable|string|min:8',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        $user = User::find($id);

        if ($user->email != $request->email) {
            $request->validate([
                'email' => 'required|string|email|max:255|unique:users',
            ]);
        }

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->role_id = 2;


        if ($request->hasFile('image')) {
            // Delete the old image if exists
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            // Store the new image
            $path = $request->file('image')->store('seller', 'public');
            $user->image = $path;
        }

        $user->save();

        return response()->json(['message' => 'User Update successfully']);
    }

    public function sellerDestroy($id)
    {
        $seller_details = User::findOrFail($id);
        if ($seller_details->image) {
            Storage::disk('public')->delete($seller_details->image);
        }
        $seller_details->delete();
        return response()->json(['message' => 'User Deleted successfully']);
    }





    function userIndex()
    {
        $roles = Roles::all();

        return view('adminPanel.user.index', compact('roles'));
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
            'role_id' => $request->role_id,
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

        if ($user->email != $request->email) {
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
        return view('adminPanel.classes.index', compact('classes'));
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
        return view('adminPanel.subject.index', compact('classes'));
    }

    function subjectStore(Request $request)
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





    //sell

    public function getSellerUnpaidAmount(Request $request, $sellerId)
    {
        $sellers = User::find($sellerId);
        return response()->json($sellers);
    }

    public function bookUnitPrice(Request $request, $sellerId)
    {
        $unitPrice=StoreBook::where('subject_id', $sellerId)->select('unit_price')->latest()->first();
        return $unitPrice;
    }



    public function createSell()
    {

        $sellers = User::where('role_id', 2)->get();
        $printingPress = PrintingPress::all();
        $classes = Classes::all();
        $subjects = Subjects::all();
        $bookStorages = StoreBook::with('printingPress')->with('subject')->with('classes')->orderBy('id', 'desc')->get();

        return view('adminPanel.transfer_to_seller.transfer_to_seller', compact('sellers', 'printingPress', 'classes', 'subjects'));
    }

    public function sellTableData()
    {

        $booksInSeller = Sell::with('class')->with('subject')->with('seller')->orderBy('id', 'desc')->get();

        $html = view('adminPanel.transfer_to_seller.books_transfer_list', compact('booksInSeller'))->render();
        return response()->json(['html' => $html]);
    }

    function sellStore(Request $request)
    {
        $request->validate([
            'sellerID' => 'required',
            'classID' => 'required',
            'subjectID' => 'required',
            'purchase_price'=>'required',
            'unit_price' => 'required',
            'total_unit' => 'required',
            'paid_amount' => 'required',
            'unpaid_amount' => 'required',
        ]);

        $subject_detail = Subjects::find($request->input('subjectID'));

        if ($subject_detail->total_unit >= $request->input('total_unit')) {

            $profit_per_unit=$request->input('unit_price') - $request->input('purchase_price');
            $total_profit= $profit_per_unit * $request->input('total_unit');

            $bookInseller = new Sell();
            $bookInseller->seller_id = $request->input('sellerID');
            $bookInseller->class_id = $request->input('classID');
            $bookInseller->subject_id = $request->input('subjectID');
            $bookInseller->purchase_price = $request->input('purchase_price');
            $bookInseller->unit_price = $request->input('unit_price');
            $bookInseller->total_unit = $request->input('total_unit');
            $bookInseller->paid_amount = $request->input('paid_amount');
            $bookInseller->unpaid_amount = $request->input('unpaid_amount');
            $bookInseller->profit = $total_profit;
            $bookInseller->save();

            $total_books_in_this_subject = $subject_detail->total_unit - $request->input('total_unit');
            $subject_detail->update([
                'total_unit' => $total_books_in_this_subject,
            ]);




            return response()->json(['message' => 'Book Store successfully'], 200);

        } else {
            return response()->json(['message' => 'This amount of quantity of books is not available'], 400);

        }












    }


    function sellInvoice($id)
{
    $sell_info = Sell::with('class', 'subject', 'seller')->find($id);

    if (!$sell_info) {
        return response()->json(['message' => 'Sell record not found'], 404);
    }

    $data = [
        'id' => $sell_info->id,
        'seller_name' => $sell_info->seller->name,
        'seller_address' => $sell_info->seller->address,
        'class_name' => $sell_info->class->name,
        'subject_name' => $sell_info->subject->name,
        'unit_price' => $sell_info->unit_price,
        'total_unit' => $sell_info->total_unit,
        'paid_amount' => $sell_info->paid_amount,
        'unpaid_amount' => $sell_info->unpaid_amount,
        'created'=>$sell_info->created_at->format(' F j, Y'),
    ];

    // Debug: Log data to ensure it's correct

        $pdf = PDF::setPaper('a4', 'portrait')->loadView('adminPanel.transfer_to_seller.sell_invoice', $data);

         $pdf_name = $sell_info->seller->name .".pdf";
         return $pdf->download($pdf_name);


    //  return view('adminPanel.transfer_to_seller.sell_invoice',compact('data'));
}





}
