<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; // Slide 74

class User extends Model
{
    protected $table = 'users'; 
    public $timestamps = false;
}