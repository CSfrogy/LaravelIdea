<?php

namespace App\Http\Controllers;

class SessionController
{

    public function create()
    {
        return view('auth.login');
    }
}
