<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller {

    public function showHomePage() {
        return view('home');
    }

    public function getProducts() {
        $products = Product::all();
        return response()->json($products);
    }

    public function getMacro(Request $request) {

        if (!$request->has('ingr')) {
            return [];
        }

        $appId = env('EDAMAM_API_ID');
        $appKey = env('EDAMAM_API_KEY');

        $response = Http::get('https://api.edamam.com/api/nutrition-data', [
            'app_id' => $appId,
            'app_key' => $appKey,
            'format' => 'json',
            'ingr' => $request->ingr
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return [];
    }
}
