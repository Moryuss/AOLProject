<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DataLayer;
use App\Models\Chat;

class ChatController extends Controller
{


    public function index()
    {
        try {
            $dl = new DataLayer();
            $user = auth()->user(); // Già garantito dal middleware

            $chatList = $dl->getChatsForUser($user->id);

            return view('index')
                ->with('user', $user)
                ->with('chats', $chatList);

        } catch (\Exception $e) {
            \Log::error('Errore index: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Errore nel caricamento della pagina.');
        }
    }

    public function get_chat($chat_id)
    {

        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Devi essere loggato per accedere alla chat.');
        }
        $dl = new DataLayer();

        // Invece del fake user, usa l'utente autenticato
        $user = auth()->user();

        // Opzionale: controlla che l'utente sia autenticato
        try {
            // Opzionale: verifica che l'utente abbia accesso a questa chat
            $userChats = $dl->getChatsForUser($user->id);
            $hasAccess = $userChats->contains('id', $chat_id);

            if (!$hasAccess) {
                return redirect()->back()->with('error', 'Non hai accesso a questa chat.');
            }

            $chatList = $dl->getChatsForUser($user->id);
            $usernamesOfChat = $dl->getUsersInChat($chat_id);
            $msgList = $dl->getMessagesForChat($chat_id);

            return view('index')
                ->with('user', $user)
                ->with('usernames', $usernamesOfChat)
                ->with('chats', $chatList)
                ->with('current_chat_id', $chat_id)
                ->with('msgs', $msgList);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Errore nel caricamento della chat.');
        }

    }
}
