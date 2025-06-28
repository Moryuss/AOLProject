<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        //CREAZIONE TABELLE
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->String('chat_name');
            $table->timestamps();
        });

        // Schema::create('users', function (Blueprint $table) {
        //     $table->id();
        //     $table->String('username');
        //     $table->timestamps();
        // });

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_sender');
            $table->unsignedBigInteger('id_chat');
            $table->String('text');
            $table->timestamps();
        });

        //...[ inutile, sono gli stessi dati di msg? ]
        Schema::create('user_chat', function (Blueprint $table) {
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_chat');

            //chiave primaria composita, x non avere righe duplicate
            $table->primary(['id_user', 'id_chat']);

        });

        //CREAZIONE FOREIGN KEYS


        Schema::table('user_chat', function (Blueprint $table) {
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_chat')->references('id')->on('chats');
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->foreign('id_sender')->references('id')->on('users');
            $table->foreign('id_chat')->references('id')->on('chats');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('hotel_id')->references('id')->on('hotels');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
