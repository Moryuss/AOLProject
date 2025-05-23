<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserChat extends Model
{
    protected $table = 'user_chat';
    public $timestamps = false;

    protected $fillable = ['id_user', 'id_chat'];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class, 'id_chat');
    }

}


