<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

class CartController extends Controller {

    public function showCart() {
        if (session('user_id') == null) {
            return redirect('login');
        }
        return view('cart');
    }

    public function loadCart() {

        $user_id = session('user_id');

        if ($user_id == null) {
            return redirect('login');
        } 

        $user = User::find($user_id);
        $cibi = $user->carts()->where('ordinato', 0)->get();
        
        foreach ($cibi as $cibo) {
            $cibo->name = $cibo->product->name;
            $cibo->image = $cibo->product->image;
            $cibo->price = $cibo->product->price;
        }

        return response()->json($cibi);
    }

    public function addCart(Request $request) {

        $user_id = session('user_id');

        if ($user_id == null || $request == null) {
            return redirect('login');
        } 

        $idCibo = $request->id_cibo;
        $user = User::find($user_id);
        
        $cartItem = $user->carts()->where('product_id', $idCibo)->where('ordinato', 0)->first();

        if ($cartItem) {
            $cartItem->quantita += 1;
            $cartItem->save();
        } else {
            $newItem = new Cart();
            $newItem->user_id = $user_id;
            $newItem->product_id = $idCibo;
            $newItem->quantita = 1;
            $newItem->ordinato = 0;
            $newItem->save();
        }

        return response()->json(['ok' => true]);
    }

    public function removeCart(Request $request) {
        
        $user_id = session('user_id');

        if ($user_id == null || $request == null) {
            return redirect('login');
        } 

        $idCibo = $request->id_cibo;
        $user = User::find($user_id);

        $cartItem = $user->carts()->where('product_id', $idCibo)->where('ordinato', 0)->first();

        if ($cartItem) {
            if ($cartItem->quantita > 1) {
                $cartItem->quantita -= 1;
                $cartItem->save();
            } else {
                $cartItem->delete();
            }
        }

        return response()->json(['ok' => true]);
    }

    public function deleteCart(Request $request) {

        $user_id = session('user_id');

        if ($user_id == null || $request == null) {
            return redirect('login');
        }     

        $idCibo = $request->id_cibo;
        $user = User::find($user_id);

        $cartItem = $user->carts()->where('product_id', $idCibo)->where('ordinato', 0)->first();

        if ($cartItem) {
            $cartItem->delete();
        }

        return response()->json(['ok' => true]);
    }

    public function orderCart() {

        $user_id = session('user_id');

        if ($user_id == null || $request == null) {
            return redirect('login');
        } 

        $user = User::find($user_id);
        $elementiCarrello = $user->carts()->where('ordinato', 0)->get();

        foreach ($elementiCarrello as $elemento) {
            $elemento->ordinato = 1;
            $elemento->save();
        }

        return response()->json(['ok' => true]);
    }

    public function payCart(Request $request) {
        
        $user_id = session('user_id');

        if ($user_id == null || $request == null) {
            return redirect('login');
        }

        $response = Http::asForm()->post('https://httpbin.org/post', [
            'importo' => $request->importo
        ]);

        return response()->json($response->json());
    }
}