<?php

namespace App\Http\Controllers\API;

use App\AppUser;
use App\Http\Controllers\Controller;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->error_code = 0;
        $this->response = null;
    }
    public function index(Request $request)
    {
        // Receive all request
        $mobile_number = $request->mobile_number;
        $pin = $request->pin;
        // Add rules
        $rules = [
            "mobile_number" => "required|integer",
            "pin" => "required",
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
            $app_user = AppUser::where(['mobile_number' => $mobile_number, 'is_verified' => '1'])->first();
            if ($app_user) {
                if($pin == $app_user->pin){
                    $data = array('id'=>$app_user->id,'name'=>$app_user->name,'mobile_number'=>$app_user->mobile_number,'email_address'=>$app_user->email_address,'address'=>$app_user->address);
                    $this->response = $data;
                } else {
                    $this->error_code = -107;
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
