<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\MessageController;





Route::get('/', function () {
    return view('welcome');
});




Route::get('/', [ChatController::class, 'index'])->name('chat.index');
Route::get('/chat/{chat_selected}', [ChatController::class, 'get_chat'])->name('chat.specificChat');
Route::get('/chat/{chat_id}', [ChatController::class, 'get_chat'])->name('chat.show');


Route::get('/settings', [SettingsController::class, 'user_index'])->name('settings.index');
Route::get('/settings/{setting_selected}', [SettingsController::class, 'get_setting'])->name('settings.sidebarSetting');
Route::post('settings/update', [SettingsController::class, 'updatePersonalization'])->name('setting.update');

Route::post('/message/store', [MessageController::class, 'store'])->name('message.store');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
