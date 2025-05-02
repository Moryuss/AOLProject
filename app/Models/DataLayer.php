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
        $users = array();
        $users[] = new User(1, 'Matteo');
        $users[] = new User(2, 'Alice');
        $users[] = new User(3, 'Bob');

        foreach ($users as $user) {
            if ($user->getId() == $userId) {
                return $user;
            }
        }

        return null; // Nessun utente trovato
    }


    public function getAllUsers()
    {
        $users = array();
        $users[] = new User(1, 'Matteo');
        $users[] = new User(2, 'Alice');
        $users[] = new User(3, 'Bob');
        return $users;
    }

    public function getAllChats()
    {
        $chats = array();

        $chats[] = new Chat(1, 'Generale');
        $chats[] = new Chat(2, 'Segreta');

        return $chats;
    }

    // #TEST Method!!!
    public function getAliceChats()
    {

        $chats = array();

        $chats[] = new Chat(3, 'AliceChat');

        return $chats;
    }


    public function getUsersInChat($chatId)
    {
        if ($chatId == 1) {
            $users = array();
            $users[] = self::getUser(1);
            $users[] = self::getUser(2);
            $users[] = self::getUser(3);

            return $users;
        }
        if ($chatId == 2) {
            $users = array();
            $users[] = self::getUser(1);

            return $users;
        }
        if ($chatId == 3) {
            $users = array();
            $users[] = self::getUser(2);

            return $users;
        }
    }

    public function getChatsForUser($userId)
    {
        if ($userId == 1) {
            return self::getAllChats();
        }
        if ($userId == 2) {
            return self::getAliceChats();
        }
    }


    public function getMessagesForChat($chatId)
    {

        $messages = [
            new Message(1, 1, 1, 'Ciao a tutti!'),
            new Message(2, 1, 2, 'Ciao Matteo!'),
            new Message(3, 2, 1, 'Solo forever'),
            new Message(4, 1, 3, 'Brum Brum Patapim'),
            new Message(5, 3, 2, 'Alice alone'),

        ];

        return array_filter($messages, fn($msg) => $msg->getIdChat() == $chatId);
    }
}