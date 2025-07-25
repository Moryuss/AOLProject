<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{


    private $id;
    private $username;

    // public function __construct($identifier, $userName)
    // {
    //     $this->id = $identifier;
    //     $this->username = $userName;
    // }

    // public function getId()
    // {
    //     return $this->id;
    // }
    // public function getUsername()
    // {
    //     return $this->username;
    // }






    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    protected $attributes = [
        'role' => 'basic_user', // Qui specifichi i valori di default
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function chats()
    {
        return $this->belongsToMany(Chat::class, 'user_chat', 'id_user', 'id_chat');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'id_sender', 'id');
    }
    public function friends()
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id');
    }

}
