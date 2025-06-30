<?php

namespace App\Http\Controllers;

use Faker\Core\Color;
use Illuminate\Http\Request;
use App\Models\DataLayer;

class SettingsController extends Controller
{
    public function user_index()
    {
        return view('user.settings');
    }

    public function get_setting($settingID)
    {
        //Questo accade se provi a scrivere una lettera da url
        if (!is_numeric($settingID)) {
            // Reindirizza 
            return redirect()->back()->with('error', 'Il parametro deve essere numerico');
        }

        $settingID = (int) $settingID;
        $dl = new DataLayer();
        $basicUsers = $dl->getBasicUsers();  // Ottieni utenti basic_user tramite DataLayer
        $allUsers = $dl->getAllUsers(); // Ottieni tutti gli utenti tramite DataLayer

        if ($settingID == 1) // Se l'ID della sezione è 1, mostra la sezione per la gestione degli Amici
            return view('user.settings')->with([
                'allUsers' => $allUsers,
                'setting_selected' => $settingID
            ]);
        if ($settingID == 6) // Se l'ID della sezione è 6, mostra la sezione per la gestione degli utenti. Modo facile per non dover modificare tutto
            return view('user.settings')->with([
                'basicUsers' => $basicUsers,
                'setting_selected' => $settingID
            ]);
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
    public function updateStatus(Request $request)
    {
        $dl = new DataLayer();
        $dl->updateUserStatus(auth()->id(), $request->input('status'));

        return redirect()->back()->with('status', 'Stato aggiornato con successo!');
    }
}
