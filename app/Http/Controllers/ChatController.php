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
        $dl = new DataLayer();
        // Simulo un utente loggato (user ID)
        $fakeUser = $this->getFakeUser();

        // Finto utente attivo
        $chatList = $dl->getChatsForUser($fakeUser->id);

        return view('index')->with('user', $fakeUser)->with('chats', $chatList);
    }

    public function get_chat($chat_id)
    {
        $dl = new DataLayer();

        $fakeUser = $this->getFakeUser();

        // Finto utente: attivo

        $chatList = $dl->getChatsForUser($fakeUser->id);
        $usernamesOfChat = $dl->getUsersInChat($chat_id);
        $msgList = $dl->getMessagesForChat($chat_id);

        // dd($chatList);  // per debugging
        // dd($msgList);

        return view('index')->
            with('user', $fakeUser)->
            with('usernames', $usernamesOfChat)->
            with('chats', $chatList)->
            with('msgs', $msgList);
    }

    private function getFakeUser()
    {
        // Simulo un utente loggato (user ID)
        $dl = new DataLayer();
        return $dl->getUser(3);
    }

}
