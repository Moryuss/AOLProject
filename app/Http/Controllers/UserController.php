<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function evolve(Request $request)
    {
        $user = Auth::user();
        if ($user->role == 'basic_user') {
            $user->role = 'admin';
            $user->save();
        }

        return redirect()->back()->with('status', 'Sei diventato admin!');
    }
    public function humble(Request $request)
    {
        $user = Auth::user();
        if ($user->role == 'admin') {
            $user->role = 'basic_user';
            $user->save();
        }

        return redirect()->back()->with('status', 'Sei stato declassato!');
    }
}
