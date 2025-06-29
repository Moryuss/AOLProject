<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DataLayer;
use App\Models\Chat;
use App\Models\UserChat;

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
            $current_chat = $dl->getChat($chat_id);

            return view('index')
                ->with('user', $user)
                ->with('usernames', $usernamesOfChat)
                ->with('chats', $chatList)
                ->with('current_chat', ($current_chat)) ///QUIIIIIIIIIIIIIIIIIIIIIIII
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

        // Trova o crea una chat, dipende se esiste già
        $chat = $dl->getChatBetweenUsers($idSender, $idReceiver);

        if (!$chat) {
            $chat = $dl->createChat($idSender, $idReceiver);
        }

        // Scrivi primo messaggio
        $dl->writeMsg($idSender, $chat->id, $request->input('text'));

        return redirect()->route('chat', ['chat_id' => $chat->id]);
    }


    //Per aggiungere/rimuovere dalla chat un user
    public function manageUsers(Chat $chat)
    {
        $users = User::where('id', '!=', auth()->id())->get();

        $userIdsInChat = UserChat::where('id_chat', $chat->id)->pluck('id_user')->toArray();

        return view('manage-users', compact('chat', 'users', 'userIdsInChat'));
    }



    public function addUserToChat(Chat $chat, User $user)
    {
        $dl = new DataLayer();
        // Controlla che l'utente sia autenticato
        // Questo è già garantito dal middleware, ma lo aggiungo per sicurezza
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Devi essere loggato per aggiungere utenti alla chat.');
        }
        $hasAccess = $this->hasAccessToChat($chat->id);

        //controllo di sicurezza. Grazie ai middleware non dovrebbe capitare ma ...
        if (!$hasAccess || auth()->user()->role != 'admin') {
            return redirect()->back()->with('error', 'Non hai accesso a questa chat.');
        }

        $exists = $dl->checkUserInChat($user->id, $chat->id);


        if (!$exists) {
            $dl->addUserToChat($user->id, $chat->id);
        }

        return redirect()->route('chat.manageUsers', $chat->id)->with('success', 'Utente aggiunto alla chat');
    }

    public function removeUserFromChat(Chat $chat, User $user)
    {
        $dl = new DataLayer();
        // Controlla che l'utente sia autenticato
        // Questo è già garantito dal middleware, ma lo aggiungo per sicurezza
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Devi essere loggato per aggiungere utenti alla chat.');
        }
        $hasAccess = $this->hasAccessToChat($chat->id);

        //controllo di sicurezza. Grazie ai middleware non dovrebbe capitare ma ...
        if (!$hasAccess || auth()->user()->role != 'admin') {
            return redirect()->back()->with('error', 'Non hai accesso a questa chat.');
        }
        UserChat::where('id_user', $user->id)
            ->where('id_chat', $chat->id)
            ->delete();

        return redirect()->route('chat.manageUsers', $chat->id)->with('success', 'Utente rimosso dalla chat');
    }

    public function rename(Request $request)
    {
        $request->validate([
            'id_chat' => 'required|exists:chats,id',
            'chat_name' => 'required|string|max:255',
        ]);

        $chat = Chat::findOrFail($request->input('id_chat'));
        $chat->chat_name = $request->input('chat_name');
        $chat->save();

        return redirect()->back()->with('success', 'Nome della chat aggiornato');
    }


    private function hasAccessToChat(int $chatId)
    {
        $dl = new DataLayer();
        // Controlla che l'utente abbia accesso alla chat, altrimenti passsando dall'url tutti potevano modificare 
        // le chat degli altri
        $userAdmin = auth()->user();
        $userChats = $dl->getChatsForUser($userAdmin->id);
        $hasAccess = $userChats->contains('id', $chatId);
        return $hasAccess;
    }

}
