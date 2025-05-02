<?php

namespace App\Http\Controllers;

use Faker\Core\Color;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function user_index()
    {
        return view('user.settings');
    }

    public function get_setting(int $settingID)
    {
        return view('user.settings')->with('setting_selected', $settingID);
    }

    public function updatePersonalization(Request $request)
    {
        // dunque session é una variabile globale, che viene sempre passata tra le pagine. 
        // puó tornare utile se qualcosa deve essere prtoato in giro fes
        session([
            'font' => $request->input('font', 'Tahoma'),
            'font_size' => $request->input('font_size', 14),
            'font_color' => $request->input('font_color', '#000000'),
            'bg_color' => $request->input('bg_color', '#ffffff'),
        ]);

        return view('user.settings');
    }
}
