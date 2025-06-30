<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FriendshipController;




Route::get('/', function () {
    return view('welcome');
});



// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{chat_selected}', [ChatController::class, 'get_chat'])->name('chat.specificChat');
    #Route::get('/chat/{chat_id}', [ChatController::class, 'get_chat'])->name('chat');

    Route::get('/chat_index', [ChatController::class, 'search_chat'])->name('chat.search');
    Route::post('/chat_index/{user}', [ChatController::class, 'start_chat'])->name('chat.start'); ##


    Route::get('/settings', [SettingsController::class, 'user_index'])->name('settings.index');
    Route::get('/settings/{setting_selected}', [SettingsController::class, 'get_setting'])->name('settings.sidebarSetting');
    Route::post('settings/update', [SettingsController::class, 'updatePersonalization'])->name('setting.update');

    Route::post('/message/store', [MessageController::class, 'store'])->name('message.store');


    #ora inutilizzati, sostituiti da upgrade
    Route::post('/evolve', [UserController::class, 'evolve'])->name('user.evolve');
    Route::post('/humble', [UserController::class, 'humble'])->name('user.humble');


    Route::post('/user/status/update', [SettingsController::class, 'updateStatus'])->name('user.status.update');

    Route::post('/friend/add', [FriendshipController::class, 'add'])->name('friend.add');
    Route::delete('/friend/remove/{friend}', [FriendshipController::class, 'remove'])->name('friend.remove');
});

Route::middleware(['auth', 'isRegisteredUser'])->group(function () {
    // Diventare admin (solo per utenti normali con password segreta)
    Route::post('/admin/upgrade', [UserController::class, 'upgrade'])->name('admin.upgrade');
});

Route::middleware(['auth', 'isAdmin'])->group(function () {

    Route::post('/chat/rename', [ChatController::class, 'rename'])->name('chat.rename');

    #Risolto questo come risolto in ChatController il problema di accedere a chat non proprie
    Route::get('/chat/manage-users/{chat}', [ChatController::class, 'manageUsers'])->name('chat.manageUsers');
    Route::post('/chat/manage-users/{chat}/add/{user}', [ChatController::class, 'addUserToChat'])->name('chat.addUser');
    Route::post('/chat/manage-users/{chat}/remove/{user}', [ChatController::class, 'removeUserFromChat'])->name('chat.removeUser');

    // Promuovere altri utenti (solo per admin)
    Route::post('/admin/promote', [UserController::class, 'promote'])->name('admin.promote');
});

require __DIR__ . '/auth.php';
