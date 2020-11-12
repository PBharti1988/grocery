<?php

namespace App\Http\Controllers\API;

use App\AppUser;
use App\Http\Controllers\Controller;
use App\OtpVerification;
use App\Setting;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
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

        // Add rules
        $rules = [
            "mobile_number" => "required|integer",
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
            $app_user = AppUser::where('mobile_no', $mobile_number)->first();
            if ($app_user) {
                $otp = rand(100000, 999999);
                $setting = Setting::where('setting_key', 'otp_expiry')->first();
                $otp_expiry = $setting->setting_value;
                $send_otp = OtpVerification::where('mobile_number', $mobile_number)
                    ->update(['otp' => $otp, 'otp_expiry' => Carbon::now()->addMinutes($otp_expiry)]);

                $this->error_code = 0;
                $this->response = array('OTP' => $otp);

            } else {
                $this->error_code = -105;
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

    public function forgotPasswordOtpVerify(Request $request)
    {
        // Receive all request
        $mobile_number = $request->mobile_number;
        $otp = $request->otp;

        // Add rules
        $rules = [
            "mobile_number" => "required|integer",
            "otp" => "required",
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
            $otp_verification = OtpVerification::where('mobile_number', $mobile_number)->first();
            if ($otp_verification) {
                $otp_expiry = $otp_verification->otp_expiry;
                $current_time = date("Y-m-d H:i:s");
                if ($current_time < $otp_expiry) {
                    if ($otp_verification->otp == $otp) {
                        $this->error_code = 0;

                    } else {
                        $this->error_code = -109;
                    }
                } else {
                    $this->error_code = -108;
                }
            } else {
                $this->error_code = -100;
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

    public function updatePassword(Request $request)
    {
        // Receive all request
        $mobile_number = $request->mobile_number;
        $password = $request->password;
        $confirm_password = $request->confirm_password;

        // Add rules
        $rules = [
            "mobile_number" => "required|integer",
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
            $check_user = AppUser::where('mobile_no', $mobile_number)->first();
            if ($check_user) {
                if ($password == $confirm_password) {
                    AppUser::where('mobile_no', $mobile_number)
                        ->update(['password' => Hash::make($password)]);
                    $this->error_code = 0;

                } else {
                    $this->error_code = -104;
                }
            } else {
                $this->error_code = -100;
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
