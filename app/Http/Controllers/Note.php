<?php

namespace App\Http\Controllers;

use JWTAuth;

class Note extends Controller
{
    public function get()
    {
        return JWTAuth::user();
    }
}
