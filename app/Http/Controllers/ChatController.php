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

    public function search_chat()
    {
        $users = User::where('id', '!=', auth()->id())->get();

        return view('chat_index', compact('users'));
    }


    public function start_chat(Request $request, $userID)
    {

        $request->validate([
            'text' => 'required|string|min:1',
        ], [
            'text.required' => 'Inserisci un messaggio per chattare.',
        ]);

        $dl = new DataLayer();
        $idSender = auth()->id();
        $idReceiver = $userID;

        // Trova o crea una chat 
        $chat = $dl->getChatBetweenUsers($idSender, $idReceiver);

        if (!$chat) {
            $chat = $dl->createChat($idSender, $idReceiver);
        }

        // Scrivi primo messaggio
        $dl->writeMsg($idSender, $chat->id, $request->input('text'));

        return redirect()->route('chat', ['chat_id' => $chat->id]);
    }


    //Per aggiungere/rimuovere dalla chat un user
    public function manageUsers(Request $request)
    {

    }

    public function rename(Request $request)
    {

    }

}
