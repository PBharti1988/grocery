<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::check()) {
            return redirect('/super-admin');
        } else {

            return view('superadmin.login');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
       
        $email = $request->input('email');
        $password = $request->input('password');

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
         
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
           
            return redirect('/super-admin');
        } else {
            $request->session()->flash('error', 'Invalid E-mail or Password!');
            return redirect()->back();
        }

    }

}
