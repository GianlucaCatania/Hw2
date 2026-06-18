<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller {
    
    public function showProfile() {

        if (!Session::has('user_id')) {
            return redirect('login');
        }

        $user = User::find(Session::get('user_id'));

        return view('profile', [
            'user' => $user,
            'auth' => true,
        ]);
    }

    public function updateProfile(Request $request) {
        if (!Session::has('user_id')) {
            return redirect('login');
        }

        $user = User::find(Session::get('user_id'));
        $errori = []; 

        if (empty($request->name)) {
            $errori['name'] = 'Il nome non può essere vuoto';
        }
        if (empty($request->surname)) {
            $errori['surname'] = 'Il cognome non può essere vuoto';
        }
        if (empty($request->username)) {
            $errori['username'] = 'Lo username non può essere vuoto';
        }
        if (empty($request->email) || !filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $errori['email'] = 'Email non valida';
        }

        if (!empty($request->old_password) || !empty($request->password) || !empty($request->confirm_password)) {
            
            if (empty($request->old_password) || !password_verify($request->old_password, $user->password)) {
                $errori['old_password'] = 'La vecchia password inserita non è corretta o mancante';
            } elseif (empty($request->password) || strlen($request->password) < 4) {
                $errori['password'] = 'La nuova password deve avere almeno 4 caratteri';
            } elseif ($request->password !== $request->confirm_password) {
                $errori['confirm_password'] = 'Le nuove password non coincidono';
            } else {
                $user->password = password_hash($request->password, PASSWORD_BCRYPT);
            }
        }

        if (count($errori) > 0) {
            $user->name = $request->name;
            $user->surname = $request->surname;
            $user->username = $request->username;
            $user->email = $request->email;

            return view('profile', [
                'user' => $user, 
                'auth' => true, 
                'error' => $errori
            ]);
        }

        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->save();
        
        Session(['username' => $user->username]);

        return view('profile', [
            'user' => $user, 
            'auth' => true, 
            'success' => 'Profilo aggiornato con successo!'
        ]);
    }
}