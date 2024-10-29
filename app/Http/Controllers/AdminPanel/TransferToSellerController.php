<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\BookStorage;
use Illuminate\Http\Request;
use App\Models\Sell;
use App\Models\Classes;
use App\Models\PrintingPress;
use App\Models\Subjects;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class TransferToSellerController extends Controller
{

    public function createSell()
    {

        $sellers = User::where('role_id', 2)->get();
        $printingPress = PrintingPress::all();
        $classes = Classes::all();
        $subjects = Subjects::all();
        $bookStorages = BookStorage::with('printingPress')->with('subject')->with('classes')->orderBy('id', 'desc')->get();

        return view('adminPanel.transfer_to_seller.transfer_to_seller', compact('sellers', 'printingPress', 'classes', 'subjects'));
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
    public function sellTableData()
    {
        $booksInSeller = Sell::with('class')->with('subject')->with('seller')->orderBy('id', 'desc')->get();

        $html = view('adminPanel.transfer_to_seller.books_transfer_list', compact('booksInSeller'))->render();
        return response()->json(['html' => $html]);
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
