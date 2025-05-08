<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Chat;
use App\Models\Message;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Chat::factory()->count(20)->create();

        $users = User::all();
        $chats = Chat::all();

        foreach ($chats as $chat) {
            $numberOfMsg = rand(1, 6);
            for ($b = 0; $b < $numberOfMsg; $b++) {
                $sender = $users->random();
                Message::factory()->count(1)->create(['id_sender' => $sender->id, 'id_chat' => $chat->id]);

                $chat->users()->syncWithoutDetaching([$sender->id]);

            }
        }
    }
}
