<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller {

    public function showLoginForm() {
        if (session('user_id') != null) {
            return redirect('home');
        }  
        return view('auth.login');
    }

    public function checkLogin(Request $request) {
        $user = User::where('username', $request->username)->first();

        if ($user !== null && password_verify($request->password, $user->password)) {
            session(['username' => $user->username, 'user_id' => $user->id]);
            return redirect('home');
        }

        return view('auth.login', ['error' => 'Username e/o password errati.']);
    }

    public function logout() {
        session()->flush();
        return redirect('login');
    }
}