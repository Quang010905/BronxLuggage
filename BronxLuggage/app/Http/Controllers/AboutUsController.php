<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AboutUsController extends Controller
{
    public function AuthLogin(){
        $id = Session::get('id');
        if($id){
           return redirect::to('home/index');
        } else{
           return redirect::to('login/index')->send();
        }
    }
    public function index()
    {
        return view('aboutus/index');
    }

}