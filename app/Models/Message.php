<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    protected $table = 'messages';

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

    public function getIdChat()
    {
        return $this->id_chat;
    }

    public function getIdSender()
    {
        return $this->id_sender;
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class, 'id_chat', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_sender', 'id');

    }
}
