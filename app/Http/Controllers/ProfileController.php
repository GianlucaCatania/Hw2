<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller {
    
    public function showProfile() {

        $user_id = session('user_id');

        if ($user_id == null) {
            return redirect('login');
        }

        $user = User::find($user_id);

        return view('profile', [
            'user' => $user
        ]);
    }

    public function updateProfile(Request $request) {

        $user_id = session('user_id');

        if ($user_id == null) {
            return redirect('login');
        }

        $user = User::find($user_id);
        $errors = [];

        if (empty($request->name)) {
            $errors['name'] = 'Il nome non può essere vuoto';
        }
        if (empty($request->surname)) {
            $errors['surname'] = 'Il cognome non può essere vuoto';
        }
        if (empty($request->username)) {
            $errors['username'] = 'Lo username non può essere vuoto';
        }
        if (empty($request->email) || !filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email non valida';
        }

        if (!empty($request->old_password) || !empty($request->password) || !empty($request->confirm_password)) {
            
            if (empty($request->old_password) || !password_verify($request->old_password, $user->password)) {
                $errors['old_password'] = 'La vecchia password inserita non è corretta o mancante';
            } elseif (empty($request->password) || strlen($request->password) < 4) {
                $errors['password'] = 'La nuova password deve avere almeno 4 caratteri';
            } elseif ($request->password !== $request->confirm_password) {
                $errors['confirm_password'] = 'Le nuove password non coincidono';
            } else {
                $user->password = password_hash($request->password, PASSWORD_BCRYPT);
            }
        }

        if (count($errors) > 0) {
            return redirect('profile')
                ->withInput()
                ->withErrors($errors);
        }

        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->save();
        
        session(['username' => $user->username]);
        
        return view('profile', [
            'user' => $user, 
            'success' => 'Profilo aggiornato con successo!'
        ]);
    }

    public function checkUsername(Request $request) {
        $user_id = session('user_id');
        $utente = User::where('username', $request->q)->where('id', '!=', $user_id)->first();
        $exists = false;
        if($utente) $exists = true;
        return ['exists' => $exists];
    }

    public function checkEmail(Request $request) {
        $user_id = session('user_id');
        $utente = User::where('email', $request->q)->where('id', '!=', $user_id)->first();
        $exists = false;
        if($utente) $exists = true;
        return ['exists' => $exists];
    }
}