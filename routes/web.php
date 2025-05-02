<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\SettingsController;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/', [ChatController::class, 'index'])->name('chat.index');
Route::get('/chat/{chat_selected}', [ChatController::class, 'get_chat'])->name('chat.specificChat');

Route::get('/settings', [SettingsController::class, 'user_index'])->name('settings.index');
Route::get('/settings/{setting_selected}', [SettingsController::class, 'get_setting'])->name('settings.sidebarSetting');
Route::post('settings/update', [SettingsController::class, 'updatePersonalization'])->name('setting.update');