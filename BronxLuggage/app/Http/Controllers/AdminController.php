<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
session_start();
class AdminController extends Controller
{
    public function AuthLogin(){
        $id = Session::get('id');
        if($id){
           return redirect::to('admin/dashboard');
        } else{
           return redirect::to('admin/login')->send();
        }
    }

    public function index()
    {
        return view('layout/admin_login');
    }

    public function dashboard()
    {
        $this->AuthLogin();
        return view('admin/dashboard');
    }

    public function admindashboard(Request $request)
    {
        $admin_email = $request->post('email');
        $admin_password = $request->post('password');

        $admin = Admin::where('email', $admin_email)->first();
   
        if ($admin && Hash::check($admin_password, $admin->password)) {
            session()->put('name', $admin->name);
            session()->put('id', $admin->id);
            return view('admin/dashboard')->with('admin', $admin);
        } else {
            $request->session()->flash('msg', 'Wrong Password');
            return redirect('admin/login');
        }
    }

    public function logout(Request $request)
    {
        $admin_email = $request->post('email');
        $admin_password = $request->post('password');

        $admin = Admin::where('email', $admin_email)->first();
        session()->put('name', null);
        session()->put('id', null);
        return redirect('/admin/login');
    }
}
