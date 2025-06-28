<?php

namespace App\Http\Controllers;

use App\Models\DataLayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    protected $SECRET_ADMIN_PASSWORD = 'admin123';
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


    public function upgrade(Request $request)
    {
        $request->validate([
            'secret_password' => 'required|string'
        ]);

        $user = Auth::user();

        if ($user->role == 'admin') {
            return back()->with('error', 'Sei già un admin!');
        }

        if ($request->secret_password !== $this->SECRET_ADMIN_PASSWORD) {
            return back()->with('error', 'Password segreta errata!');
        }

        $user->role = 'admin';
        $user->save();

        // Logout e re-login per applicare i cambiamenti
        Auth::logout();
        return redirect('/login')->with('success', 'Accesso nuovamente per completare l\'upgrade ad admin!');
    }

    public function promote(Request $request)
    {
        $dl = new DataLayer();
        $request->validate([
            'user_id' => 'required|integer|exists:users,id'
        ]);

        $admin = auth()->user();
        $targetUser = $dl->getUser($request->user_id);

        if ($targetUser->role == 'admin') {
            return back()->with('error', 'Questo utente è già un admin!');
        }

        $targetUser->role = 'admin';
        $targetUser->save();
        return back()->with('success', "Utente {$targetUser->name} promosso ad admin!");
    }
}

