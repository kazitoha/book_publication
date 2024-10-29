<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Subjects;
use Illuminate\Http\Request;

class StorageAlertController extends Controller
{
    public function Index()
    {
        return view('adminPanel.storage_alert.storage_alert');
    }

   

    function Show()
    {
        $lowStockAlert = Subjects::with('classes')->where('total_unit', '<', 10)->get();

        $html = view('adminPanel.storage_alert.alert_list', compact('lowStockAlert'))->render();
        return response()->json(['html' => $html]);
    }

}
