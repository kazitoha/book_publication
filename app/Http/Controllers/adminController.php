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







}
