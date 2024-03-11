<?php

namespace App\Http\Controllers\userPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class homeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required',
            'email'=> 'required|email',
            'subject'=> 'required',
            'message'=> 'required',
        ]);
        Contact::created([
            'name'=>$request->name,
            'email'=>$request->email,
            'subject'=>$request->subject,
            'message'=>$request->message,
        ]);

        return back()->with('success_msg', 'Successfully submited.');
    }
}
