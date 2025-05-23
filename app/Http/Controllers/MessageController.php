<?php

namespace App\Http\Controllers;

use App\Models\DataLayer;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $dl = new DataLayer();
        $dl->writeMsg($request->input('id_sender'), $request->input('id_chat'), $request->input('text'));
        // return view('index');

        return redirect()->route('chat', ['chat_id' => $request->input('id_chat')]);
    }

    public function edit(Request $request)
    {
        $dl = new DataLayer();
        $dl->modMsg($request->input('msgId'), $request->input('text'));

    }
}
