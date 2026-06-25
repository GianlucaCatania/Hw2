<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = false;

    public function carts() {
        return $this->hasMany(Cart::class);
    }
}
