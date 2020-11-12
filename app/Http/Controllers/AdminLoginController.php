<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use App\Restaurant;
use App\Manager;
use Illuminate\Http\Request;

class AdminLoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

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
            'password' => 'required',
        ]);

        if (Auth::guard('restaurant')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/admin');
        }elseif(Auth::guard('manager')->attempt(['email' => $request->email, 'password' => $request->password,'active'=>1])){
            return redirect('/admin');
        }
         else {
            $request->session()->flash('error', 'Invalid E-mail or Password!');
            return redirect()->back();
        }

    }

}
