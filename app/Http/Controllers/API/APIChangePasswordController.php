<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Validator;
use Hash;

class APIChangePasswordController extends Controller
{

    public function __construct()
    {
        $this->error_code = 0;
        $this->response = null;
    }

    public function ChangePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'user_id' => 'required',
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|min:6',

        ]);
        if ($validator->fails()) {
            $this->error_code = -999;
            $this->response = $validator->messages()->first();
        } else {
            try {
                $user_id = $request->user_id;
                $old_pass = $request->old_password;
                $new_pass = $request->new_password;
                $cnfm_pass = $request->confirm_password;

                $check_user = User::where('id',$user_id)->first();
                if ($check_user) {
                    
                    $check_old_pass = Auth::attempt(['id' => $user_id, 'password' => $old_pass]);

                    if ($check_old_pass) {

                        if ($new_pass == $cnfm_pass) {

                            $update = User::where('id', $user_id)->update(['password' => bcrypt($new_pass)]);

                            if ($update) {
                                $this->error_code = 0;
                            } else {
                                $this->error_code = -107;
                            }

                        } else {
                            $this->error_code = -103;
                        }

                    } else {
                        $this->error_code = -106;
                    }

                } else {
                    $this->error_code = -100;
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
