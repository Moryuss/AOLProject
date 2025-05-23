<?php

namespace App\Models;
use Illuminate\Support\Str;


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

    public function getChatBetweenUsers($id1, $id2)
    {
        $user1Chats = UserChat::where('id_user', $id1)->pluck('id_chat')->toArray();
        $user2Chats = UserChat::where('id_user', $id2)->pluck('id_chat')->toArray();

        $commonChatIds = array_intersect($user1Chats, $user2Chats);

        foreach ($commonChatIds as $chatId) {
            $userCount = UserChat::where('id_chat', $chatId)->count();
            if ($userCount == 2) {
                return Chat::find($chatId);
            }
        }

        return null;
    }


    public function createChat($id1, $id2)
    {
        $chatName = $this->generateChatName($id1, $id2);

        $chat = Chat::create([
            'chat_name' => $chatName,
        ]);

        UserChat::insert([
            ['id_user' => $id1, 'id_chat' => $chat->id],
            ['id_user' => $id2, 'id_chat' => $chat->id],
        ]);

        return $chat;
    }

    private function generateChatName($id1, $id2)
    {
        $name1 = User::find($id1)->name ?? 'user1';
        $name2 = User::find($id2)->name ?? 'user2';

        return $name1 . '_and_' . $name2 . '_' . Str::random(3);
    }




}