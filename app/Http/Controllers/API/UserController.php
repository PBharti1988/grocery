<?php

namespace App\Http\Controllers\API;

use App\AppUser;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->error_code = 0;
        $this->response = null;
    }
    public function myProfile(Request $request)
    {
        // Receive all request
        $user_id = $request->user_id;
        // Add rules
        $rules = [
            "user_id" => "required|integer",
        ];
        // Set validation message
        $messages = [];
        // Show validation error
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $this->error_code = -999;
            $result = array('ErrorCode' => $this->error_code, 'ErrorMessage' => $validator->messages()->first(), 'Response' => getErrorMessage($this->error_code));
            return response()->json($result);
        }
        try {
            $app_user = AppUser::where(['id' => $user_id, 'is_verified' => '1'])->first();
            if ($app_user) {
                $data = array('id'=>$app_user->id,'name'=>$app_user->name,'mobile_number'=>$app_user->mobile_number,'email_address'=>$app_user->email_address,'address'=>$app_user->address);
                $this->response = $data;
            } else {
                $this->error_code = -108;
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
    public function editProfile(Request $request)
    {
        // Receive all request
        $user_id = $request->user_id;
        $name = $request->name;
        $mobile_number = $request->mobile_number;
        $email_address = $request->email_address;
        $address = $request->address;
        // Add rules
        $rules = [
            "user_id" => "required|integer",
        ];
        // Set validation message
        $messages = [];
        // Show validation error
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $this->error_code = -999;
            $result = array('ErrorCode' => $this->error_code, 'ErrorMessage' => $validator->messages()->first(), 'Response' => getErrorMessage($this->error_code));
            return response()->json($result);
        }
        try {
            $app_user = AppUser::where('id', $user_id)->first();
            if ($app_user) {
                $exists_mobile = AppUser::where('id', '!=', $user_id)->where('mobile_number', $mobile_number)->first();
                $exists_email = AppUser::where('id', '!=', $user_id)->where('email_address', $email_address)->first();
                if ($exists_mobile) {
                    $this->error_code = -102;
                } else if ($exists_email) {
                    $this->error_code = -103;
                } else {
                    $update_profile = AppUser::where('id', $user_id)->update(['name' => $name,'mobile_number' => $mobile_number,'email_address' => $email_address,'address' => $address]);
                    if(!$update_profile){
                        $this->error_code = -100;
                    }
                }
            } else {
                $this->error_code = -108;
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