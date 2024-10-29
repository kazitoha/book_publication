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

class UserManagementController extends Controller
{
    function Index()
    {
        $roles = Roles::all();

        return view('adminPanel.user.index', compact('roles'));
    }

    function Store(Request $request)
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

    function Show()
    {
        $users = User::with('roles')->orderBy('id', 'desc')->get();
        $html = view('adminPanel.user.user_list', compact('users'))->render();
        return response()->json(['html' => $html]);
    }


    public function Edit($id)
    {
        $users = User::find($id);
        return response()->json($users);
    }

    public function Update(Request $request, $id)
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

    public function Destroy($id)
    {
        User::destroy($id);
        return response()->json(['message' => 'User Deleted successfully']);
    }
}
