<?php

namespace App\Models;


class Chat_old
{
    private $idChat;

    private $chat_name;


    public function __construct($id, $chatName)
    {
        $this->idChat = $id;
        $this->chat_name = $chatName;
    }

    public function getIDChat()
    {
        return $this->idChat;
    }

    public function getChatName()
    {
        return $this->chat_name;
    }



}