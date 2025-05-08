<?php

namespace App\Models;

class Message_old
{
    private $idMsg;
    private $id_chat;
    private $id_sender;
    private $text;

    // Costruttore
    public function __construct($idMsg, $id_chat, $id_sender, $text)
    {
        $this->idMsg = $idMsg;
        $this->id_chat = $id_chat;
        $this->id_sender = $id_sender;
        $this->text = $text;
    }

    // Getter
    public function getIdMsg()
    {
        return $this->idMsg;
    }

    public function getIdChat()
    {
        return $this->id_chat;
    }

    public function getIdSender()
    {
        return $this->id_sender;
    }

    public function getText()
    {
        return $this->text;
    }
}