<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ThemeController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        $user =User::find($user->id);
        $user->update([
            'theme_layout' => $request->input('theme_layout'),
            'sidebar_color' => $request->input('sidebar_color'),
            'theme_color' => $request->input('theme_color'),
            'sticky_header' => $request->input('sticky_header'),
            'sidebar_mini' => $request->input('sidebar_mini'),
        ]);

        return response()->json(['success' => true]);
    }

    public function get()
    {
        $user = Auth::user();
        return response()->json([
            'theme_layout' => $user->theme_layout,
            'sidebar_color' => $user->sidebar_color,
            'theme_color' => $user->theme_color,
            'sticky_header' => $user->sticky_header,
            'sidebar_mini' => $user->sidebar_mini,
        ]);
    }
}
