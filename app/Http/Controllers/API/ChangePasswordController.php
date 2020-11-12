<?php

namespace App\Http\Controllers\API;

use App\AppUser;
use App\Http\Controllers\Controller;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->error_code = 0;
        $this->response = null;
    }
    public function index(Request $request)
    {
        // Receive all request
        $user_id = $request->user_id;
        $old_password = $request->old_password;
        $password = $request->password;
        $confirm_password = $request->confirm_password;

        // Add rules
        $rules = [
            "user_id" => "required",
            "old_password" => "required",
            "password" => "required",
            "confirm_password" => "required",
        ];
        // Set validation message
        $messages = [

        ];
        // Show validation error
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $this->error_code = -999;
            $result = array('ErrorCode' => $this->error_code, 'ErrorMessage' => $validator->messages()->first(), 'Response' => getErrorMessage($this->error_code));
            return response()->json($result);
        }

        try {
            if ($password == $confirm_password) {
                $user = AppUser::find($user_id);
                if ($user) {
                    if (Hash::check($old_password, $user->password)) {
                        $new_password = Hash::make($password);
                        AppUser::find($user_id)->update(['password' => $new_password]);
                        $this->error_code = 0;
                    } else {
                        $this->error_code = -107;
                    }
                } else {
                    $this->error_code = -100;
                }

            } else {
                $this->error_code = -104;
            }

        } catch (\Exception $e) {
            $this->error_code = -500;
            if ($request->debug == true) {
                $this->response = $e->getMessage() . ' on line number ' . $e->getLine() . ' in ' . $e->getFile();
            }
        }
        // Store result in an array
        $result = array('ErrorCode' => $this->error_code, 'ErrorMessage' => getErrorMessage($this->error_code), 'Response' => $this->response);
        // Return response
        return response()->json($result);
    }
}
