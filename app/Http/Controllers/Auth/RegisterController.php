<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller {

    public function showRegisterForm() {
        if (session('user_id') != null) {
            return redirect('home');
        }    
        return view('auth.register');
    }

    public function createUser(Request $request) {

    $error = [];

        if (empty($request->name) || empty($request->surname) || empty($request->username) || 
            empty($request->email) || empty($request->password) || empty($request->confirm_password) || 
            empty($request->allow)) {
            $error[] = "Riempi tutti i campi";
        } else {
            if (strlen($request->username) > 15) {
                $error[] = "Lo username deve essere compreso tra 1 e 15 caratteri";
            } else if (User::where('username', $request->username)->exists()) {
                $error[] = "Username già utilizzato";
            }

            if (strlen($request->password) < 8) {
                $error[] = "La password deve essere di almeno 8 caratteri";
            } 

            if ($request->password !== $request->confirm_password) {
                $error[] = "Le password non coincidono";
            }

            if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                $error[] = "Email non valida";
            } else if (User::where('email', $request->email)->exists()) {
                $error[] = "Email già utilizzata";
            }
        }

        if (count($error) > 0) {
            return view('auth.register', ['error' => $error]);
        }

        $user = new User;
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = password_hash($request->password, PASSWORD_BCRYPT);

        $user->save(); 

        session(['username' => $user->username, 'user_id' => $user->id]);
    
        return redirect('home');
    }

    public function checkUsername(Request $request) {
        $exists = User::where('username', $request->q)->exists();
        return ['exists' => $exists];
    }

    public function checkEmail(Request $request) {
        $exists = User::where('email', $request->q)->exists();
        return ['exists' => $exists];
    }
}