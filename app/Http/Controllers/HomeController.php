<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class HomeController extends Controller {

    public function showHomePage() {
        return view('home');
    }
}