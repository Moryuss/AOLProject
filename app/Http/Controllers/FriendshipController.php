<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataLayer;


class FriendshipController extends Controller
{
    public function remove($friend)
    {
        $dl = new DataLayer();

        $user = auth()->user();

        $dl->removeFriend($user->id, $friend);

        return redirect()->back()->with('status', 'Amico rimosso con successo!');
    }

    public function add(Request $request)
    {
        $dl = new DataLayer();
        $user = auth()->user();
        $friendId = $request->input('id_friend');

        // Controlla se l'ID dell'amico esiste
        $friend = $dl->getUser($friendId);
        if (!$friend) {
            return redirect()->back()->with('error', 'Utente non trovato!');
        }

        // Controlla se l'utente sta cercando di aggiungere se stesso
        if ($user->id == $friendId) {
            return redirect()->back()->with('error', 'Non puoi aggiungere te stesso!');
        }

        // Controlla se l'amicizia esiste già
        if ($dl->friendshipExists($user->id, $friendId)) {
            return redirect()->back()->with('error', 'Questo utente è già tuo amico!');
        }

        // Se tutto è OK, aggiungi l'amico
        $dl->addFriend($user->id, $friendId);
        return redirect()->back()->with('status', 'Amico aggiunto con successo!');
    }
}
