<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = 'chats';


    public function messages()
    {
        return $this->hasMany(Message::class, 'id_chat', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_chat', 'id_chat', 'id_user');
    }
}
