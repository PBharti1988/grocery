<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\User;
use App\Trainer;
use App\Dietician;
use Illuminate\Http\Request;
use Validator;
use Hash;
use Mail;
use Auth;

class APILoginController extends Controller
{

    public function __construct()
    {
        $this->error_code = 0;
        $this->response = null;
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'user_type' =>'required'
           

        ]);
        if ($validator->fails()) {
            $this->error_code = -999;
            $this->response = $validator->messages()->first();
        } else {
            try {
                $user_type =$request->user_type;
               
             if($user_type == 1){
               $checkuser = Auth::attempt(['email' => $request->email, 'password' => $request->password,'is_verified'=> 1]);
             if($checkuser){
                $user_data =User::where(['email'=>$request->email,'is_verified'=>1])->first();
                $this->error_code = 0;
                $this->response = $user_data;
             }else{
                $this->error_code = -105;
             }
             }
             
             else if($user_type == 2){
                $checkuser = Auth::guard('trainer')->attempt(['email' => $request->email, 'password' => $request->password,'is_verified'=> 1]);
                if($checkuser){

                   $user_data =User::where(['email'=>$request->email,'is_verified'=>1])->first();
                   $this->error_code = 0;
                   $this->response = $user_data;
                }else{
                   $this->error_code = -105;
                  
                }

             }
             else if($user_type == 3){
                $checkuser = Auth::guard('dietician')->attempt(['email' => $request->email, 'password' =>$request->password,'is_verified' => 1]);
                if($checkuser){

                   $user_data =User::where(['email'=>$request->email,'is_verified'=>1])->first();
                   $this->error_code = 0;
                   $this->response = $user_data;
                }else{
                   $this->error_code = -105;
                
                }

             }
              
            } catch (\Exception $e) {
                $this->error_code = 500;
                if ($request->debug == true) {
                    $this->response = $e->getMessage() . ' on line number ' . $e->getLine() . ' in ' . $e->getFile();
                }
            }
        }
        $result = array('ErrorCode' => $this->error_code, 'ErrorMessage' => getErrorMessage($this->error_code), 'Response' => $this->response);
        return response()->json($result);

    }

}
