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

        $errors = [];

        if (empty($request->name) || empty($request->surname) || empty($request->username) || 
            empty($request->email) || empty($request->password) || empty($request->confirm_password) || 
            empty($request->allow)) {
            $errors[] = "Riempi tutti i campi";

        } else {
            if (strlen($request->username) > 15) {
                $errors[] = "Lo username deve essere compreso tra 1 e 15 caratteri";
            } else if (User::where('username', $request->username)->first()) {
                $errors[] = "Username già utilizzato";
            }

            if (strlen($request->password) < 8) {
                $errors[] = "La password deve essere di almeno 8 caratteri";
            } 

            if ($request->password !== $request->confirm_password) {
                $errors[] = "Le password non coincidono";
            }

            if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email non valida";
            } else if (User::where('email', $request->email)->first()) {
                $errors[] = "Email già utilizzata";
            }
        }

        if (count($errors) > 0) {
            return redirect('register')
                ->withInput()
                ->withErrors($errors);
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
        $exists = User::where('username', $request->q)->first();
        return ['exists' => $exists];
    }

    public function checkEmail(Request $request) {
        $exists = User::where('email', $request->q)->first();
        return ['exists' => $exists];
    }
}