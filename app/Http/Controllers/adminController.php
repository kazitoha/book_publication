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





   










    //class methods






    //sell

    




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
        // Validate the request data
        $request->validate([
            'sellerID' => 'required',
            'classID.*' => 'required',
            'subjectID.*' => 'required',
            'purchase_price.*' => 'required|numeric|min:0',
            'unit_price.*' => 'required|numeric|min:0',
            'total_unit.*' => 'required|integer|min:1',
            'paid_amount' => 'required|numeric|min:0',
            'unpaid_amount' => 'required|numeric',
        ]);

        // Retrieve subject details
        $subject_details = Subjects::whereIn('id', $request->input('subjectID'))->get();

        // Prepare arrays for calculations
        $classIDs = $request->input('classID');
        $subjectIDs = $request->input('subjectID');
        $purchasePrices = $request->input('purchase_price');
        $unitPrices = $request->input('unit_price');
        $totalUnits = $request->input('total_unit');

        $total_profit = 0;

        // Check available units and calculate profit
        foreach ($subject_details as $subject_detail) {
            $subjectIndex = array_search($subject_detail->id, $subjectIDs);
            if ($subject_detail->total_unit < $totalUnits[$subjectIndex]) {
                return response()->json(['error' => 'This amount of quantity of books is not available for subject ID: ' . $subject_detail->id], 400);
            }

            $profit_per_unit = $unitPrices[$subjectIndex] - $purchasePrices[$subjectIndex];
            $total_profit += $profit_per_unit * $totalUnits[$subjectIndex];

            // Update the subject's total unit
            $subject_detail->total_unit -= $totalUnits[$subjectIndex];
            $subject_detail->save();
        }




        // Save the sale
        $bookInseller = new Sell();
        $bookInseller->seller_id = $request->input('sellerID');
        $bookInseller->class_id = json_encode($classIDs);
        $bookInseller->subject_id = json_encode($subjectIDs);
        $bookInseller->purchase_price = json_encode($purchasePrices);
        $bookInseller->unit_price = json_encode($unitPrices);
        $bookInseller->total_unit = json_encode($totalUnits);
        $bookInseller->paid_amount = $request->input('paid_amount');
        $bookInseller->unpaid_amount = $request->input('unpaid_amount');
        $bookInseller->profit = $total_profit;
        $bookInseller->save();





        return redirect()->back()->with('success', 'Book Store successfully');
    }


    public function sellInvoice($id)
    {
        $sell_info = Sell::with('seller')->find($id);

        if (!$sell_info) {
            return response()->json(['message' => 'Sell record not found'], 404);
        }

        $classIDs = json_decode($sell_info->class_id, true);
        $subjectIDs = json_decode($sell_info->subject_id, true);
        $unitPrices = json_decode($sell_info->unit_price, true);
        $totalUnits = json_decode($sell_info->total_unit, true);

        $classNames = Classes::whereIn('id', $classIDs)->pluck('name', 'id')->toArray();
        $subjectNames = Subjects::whereIn('id', $subjectIDs)->pluck('name', 'id')->toArray();

        $data = [
            'id' => $sell_info->id,
            'seller_name' => $sell_info->seller->name,
            'seller_address' => $sell_info->seller->address,
            'classes' => $classIDs,
            'subjects' => $subjectIDs,
            'classNames' => $classNames,
            'subjectNames' => $subjectNames,
            'unit_price' => $unitPrices,
            'total_unit' => $totalUnits,
            'paid_amount' => $sell_info->paid_amount,
            'unpaid_amount' => $sell_info->unpaid_amount,
            'created' => $sell_info->created_at->format('F j, Y'),
        ];


        return view('adminPanel.transfer_to_seller.sell_invoice', compact('data'));


        // $pdf = PDF::setPaper('a4', 'portrait')->loadView('adminPanel.transfer_to_seller.sell_invoice', $data);

        // $pdf_name = $sell_info->seller->name . ".pdf";
        // return $pdf->download($pdf_name);
    }




    public function sellInvoicepdf($id)
    {
        $sell_info = Sell::with('seller')->find($id);

        if (!$sell_info) {
            return response()->json(['message' => 'Sell record not found'], 404);
        }

        $classIDs = json_decode($sell_info->class_id, true);
        $subjectIDs = json_decode($sell_info->subject_id, true);
        $unitPrices = json_decode($sell_info->unit_price, true);
        $totalUnits = json_decode($sell_info->total_unit, true);

        $classNames = Classes::whereIn('id', $classIDs)->pluck('name', 'id')->toArray();
        $subjectNames = Subjects::whereIn('id', $subjectIDs)->pluck('name', 'id')->toArray();

        $data = [
            'id' => $sell_info->id,
            'seller_name' => $sell_info->seller->name,
            'seller_address' => $sell_info->seller->address,
            'classes' => $classIDs,
            'subjects' => $subjectIDs,
            'classNames' => $classNames,
            'subjectNames' => $subjectNames,
            'unit_price' => $unitPrices,
            'total_unit' => $totalUnits,
            'paid_amount' => $sell_info->paid_amount,
            'unpaid_amount' => $sell_info->unpaid_amount,
            'created' => $sell_info->created_at->format('F j, Y'),
        ];

        $pdf = PDF::setPaper('a4', 'portrait')->loadView('adminPanel.transfer_to_seller.sell_invoice', $data);

        $pdf_name = $sell_info->seller->name . ".pdf";
        return $pdf->download($pdf_name);
    }
}
