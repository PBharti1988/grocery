<?php

namespace App\Http\Controllers\API;

use App\AppUser;
use App\OtpVerification;
use App\Setting;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SignupController extends Controller
{
    public function __construct()
    {
        $this->error_code = 0;
        $this->response = null;
    }
    public function index(Request $request)
    {
        // Receive all request
        $name = $request->name;
        $mobile_number = $request->mobile_number;
        $email_address = $request->email_address;
        $address = $request->address;
        // Add rules
        $rules = [
            "name" => "required",
            "mobile_number" => "required|integer",
            "email_address" => "required|email",
            "address" => "required",
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
            $exists_mobile = AppUser::where(['mobile_number' => $mobile_number, 'is_verified' => '1'])->first();
            $exists_email = AppUser::where(['email_address' => $email_address, 'is_verified' => '1'])->first();
            if ($exists_mobile) {
                $this->error_code = -102;
            } else if ($exists_email) {
                $this->error_code = -103;
            } else {
                $exists_mobile = AppUser::where(['mobile_number' => $mobile_number])->first();
                $exists_email = AppUser::where(['email_address' => $email_address])->first();
                if(!$exists_mobile){
                    if($exists_email){
                        $this->error_code = -103;
                        $result = array('ErrorCode' => $this->error_code, 'ErrorMessage' => $validator->messages()->first(), 'Response' => getErrorMessage($this->error_code));
                        return response()->json($result);
                    }
                }

                $app_user_id = AppUser::updateOrCreate(
                    ['mobile_number' => $mobile_number],
                    ['name' => $name,'mobile_number'=>$mobile_number,'email_address'=>$email_address,'address' =>$address]
                )->id;
                
                $otp = rand(1000, 9999);
                $setting = Setting::where('setting_key', 'otp_expiry')->first();
                $expiry = $setting->setting_value;
                if ($expiry == 'never') {
                    $otp_expiry = null;
                } else {
                    $otp_expiry = Carbon::now()->addMinutes($expiry);
                }
                OtpVerification::updateOrCreate(
                    ['mobile_number' => $mobile_number],
                    ['otp' => $otp,'email_address'=>$email_address,'otp_expiry' =>$otp_expiry]
                );
                send_local_sms($mobile_number,$otp. ' is the OTP to register in the app.');
                $data = array('OTP'=>$otp);
                $this->response = $data;
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
    public function verifyOTP(Request $request)
    {
        // Receive all request
        $mobile_number = $request->mobile_number;
        $otp = $request->otp;
        // Add rules
        $rules = [
            "mobile_number" => "required|integer",
            "otp" => "required|digits:4",
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
            $app_user = AppUser::where(['mobile_number' => $mobile_number])->first();
            if ($app_user) {
                $otp_verification = OtpVerification::where('mobile_number', $mobile_number)->first();
                if ($otp_verification) {
                    $otp_expiry = $otp_verification->otp_expiry;
                    if ($otp_expiry == null) {
                        if ($otp_verification->otp == $otp) {
                            AppUser::where('id',$app_user->id)->update(['is_verified' => '1']);
                        }
                        else {
                            $this->error_code = -106;
                        }
                    } else {
                        $current_time = date("Y-m-d H:i:s");
                        if ($otp_verification->otp == $otp) {
                            if ($current_time < $otp_expiry) {
                                AppUser::where('id',$app_user->id)->update(['is_verified' => '1']);
                            }
                            else{
                                $this->error_code = -105;
                            }
                        }
                        else {
                            $this->error_code = -106;
                        }
                    }
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
    public function createPIN(Request $request)
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
                AppUser::where('mobile_number', $mobile_number)->update(['pin' => $pin]);
                $data = array('id'=>$app_user->id,'name'=>$app_user->name,'mobile_number'=>$app_user->mobile_number,'email_address'=>$app_user->email_address,'address'=>$app_user->address);
                $this->response = $data;
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
    public function forgotPIN(Request $request)
    {
        // Receive all request
        $mobile_number = $request->mobile_number;
        // Add rules
        $rules = [
            "mobile_number" => "required|integer",
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
                $otp = rand(1000, 9999);
                $setting = Setting::where('setting_key', 'otp_expiry')->first();
                $expiry = $setting->setting_value;
                if ($expiry == 'never') {
                    $otp_expiry = null;
                } else {
                    $otp_expiry = Carbon::now()->addMinutes($expiry);
                }
                OtpVerification::updateOrCreate(
                    ['mobile_number' => $mobile_number],
                    ['otp' => $otp,'otp_expiry' =>$otp_expiry]
                );
                send_local_sms($mobile_number,$otp. ' is the OTP to reset your PIN.');
                $data = array('OTP'=>$otp);
                $this->response = $data;
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
    public function changePIN(Request $request)
    {
        // Receive all request
        $user_id = $request->user_id;
        $old_pin = $request->old_pin;
        $new_pin = $request->new_pin;
        $confirm_pin = $request->confirm_pin;
        // Add rules
        $rules = [
            "user_id" => "required|integer",
            "old_pin" => "required|integer",
            "new_pin" => "required|integer",
            "confirm_pin" => "required|integer",
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
            $app_user = AppUser::where('id', $request->user_id)->first();
            if ($app_user) {
                if($new_pin == $confirm_pin){
                    $old_pin = AppUser::where('pin', $old_pin)->first();
                    if($old_pin){
                        $change_pin = AppUser::where('id', $user_id)->update(['pin' => $new_pin]);
                        if(!$change_pin){
                            $this->error_code = -100;
                        }
                    }
                    else{
                        $this->error_code = -110;
                    }
                }
                else{
                    $this->error_code = -109;
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
