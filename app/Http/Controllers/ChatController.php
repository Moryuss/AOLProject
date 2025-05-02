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
        $chatList = $dl->getChatsForUser($fakeUser->getId());

        return view('index')->with('user', $fakeUser)->with('chats', $chatList);
    }

    public function get_chat($chat_id)
    {
        $dl = new DataLayer();

        $fakeUser = $this->getFakeUser();

        // Finto utente: attivo

        $chatList = $dl->getChatsForUser($fakeUser->getId());
        $usernames_chat = $dl->getUsersInChat($chat_id);
        $msgList = $dl->getMessagesForChat($chat_id);


        return view('index')->
            with('user', $fakeUser)->
            with('usernames', $usernames_chat)->
            with('chats', $chatList)->
            with('msgs', $msgList);
    }

    private function getFakeUser(): User
    {
        // Simulo un utente loggato (user ID)
        return new User(1, 'Matteo');
        // return new User(2, 'Alice');

    }

}
