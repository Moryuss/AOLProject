<?php

namespace App\Models;

class DataLayer
{
    #è la relazione ponte tra chat e user, da sostituire con Models/Relations.php
    public function getRelations()
    {
        return [
            ['chat_id' => 1, 'user_id' => 1],
            ['chat_id' => 1, 'user_id' => 2],
            ['chat_id' => 2, 'user_id' => 3],
        ];
    }

    public function getUser($userId)
    {
        return User::find($userId);
    }


    public function getAllUsers()
    {
        return User::all();
    }

    public function getAllChats()
    {
        return Chat::all();
    }

    // #TEST Method!!!


    public function getUsersInChat($chatId)
    {
        return User::findMany($chatId);
    }

    public function getChatsForUser($userId)
    {
        return User::findOrFail($userId)->chats;
    }


    public function getMessagesForChat($chatId)
    {
        return Message::where('id_chat', $chatId)->get();
    }


    public function writeMsg($senderId, $chatId, $text)
    {
        $msg = new Message();
        $msg->id_sender = $senderId;
        $msg->id_chat = $chatId;
        $msg->text = $text;
        $msg->save();
    }
    public function modMsg($msgId, $text)
    {
        $msg = Message::find($msgId);
        $msg->text = $text;
        $msg->save();
    }
}