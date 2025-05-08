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


    }
}
