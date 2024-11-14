<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;


class RegisterController extends Controller
{
    public function index()
    {
        return view('register/index');
    }
}