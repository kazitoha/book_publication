<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\StoreBook;
use App\Models\Subjects;
use App\Models\User;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function getSubjectsByClass(Request $request, $classId)
    {
        $subjects = Subjects::where('class_id', $classId)->get();
        return response()->json($subjects);
    }

    public function getSellerUnpaidAmount(Request $request, $sellerId)
    {
        $sellers = User::find($sellerId);
        return response()->json($sellers);
    }
    public function bookUnitPrice(Request $request, $sellerId)
    {
        $unitPrice = StoreBook::where('subject_id', $sellerId)->select('unit_price')->latest()->first();
        return $unitPrice;
    }


}
