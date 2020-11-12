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

class APIRegisterController extends Controller
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
        $email = $request->email;
        $mobile_number = $request->mobile;
        $password = $request->password;
        $confirm_password = $request->confirm_password;
        $otp = $request->otp;
        // Add rules
        $rules = [
            "name" => "required",
            "email" => "required|email",
            "mobile" => "required|integer",
            "password" => "required",
            "confirm_password" => "required",
            'otp' => 'nullable|digits:6',
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
          
          
            $exists_mobile = AppUser::where(['mobile_no' => $mobile_number, 'is_verified' => '1'])->first();
            $exists_email = AppUser::where(['email_id' => $email, 'is_verified' => '1'])->first();
            if ($exists_mobile) {
                $this->error_code = -102;
            } else if ($exists_email) {
                $this->error_code = -103;
            } else {
                if ($password == $confirm_password) {
                    if ($request->otp) {
                        $otp_verification = OtpVerification::where('mobile_number', $mobile_number)->first();
                        if ($otp_verification) {
                            $otp_expiry = $otp_verification->otp_expiry;
                            if ($otp_expiry == null) {
                                if ($otp_verification->otp == $otp) {
                                    $app_user = AppUser::where('mobile_no', $mobile_number)->first(['id','name','email_id','mobile_no']);
                                    AppUser::find($app_user->id)->update(['is_verified' => '1']);
                                    $this->error_code = 0;
                                    $this->response = $app_user;

                                } else {
                                    $this->error_code = -109;
                                }
                            } else {
                                $current_time = date("Y-m-d H:i:s");
                                if ($current_time < $otp_expiry) {
                                    if ($otp_verification->otp == $otp) {
                                        $app_user = AppUser::where('mobile_no', $mobile_number)->first(['id','name','email_id','mobile_no']);
                                        AppUser::where('id',$app_user->id)->update(['is_verified' => '1']);
                                        $this->error_code = 0;
                                        $this->response = $app_user;
    
                                    } else {
                                        $this->error_code = -109;
                                    }
                                } else {
                                    $this->error_code = -108;
                                }
                            }
                        }
                    } else {
                        $otp = rand(100000, 999999);
                        $setting = Setting::where('setting_key', 'otp_expiry')->first();
                        $expiry = $setting->setting_value;
                        if ($expiry == 'never') {
                            $otp_expiry = null;
                        } else {
                            $otp_expiry = Carbon::now()->addMinutes($expiry);
                        }

                        OtpVerification::updateOrCreate(
                            ['mobile_number' => $mobile_number],
                            ['otp' => $otp,'email'=>$email,'otp_expiry' => Carbon::now()->addMinutes($otp_expiry)]
                        );

                        $request->merge(['mobile_no' => $mobile_number, 'email_id' => $email, 'is_verified' => '0']);
                        $app_user_id = AppUser::create($request->only('name', 'email_id', 'mobile_no', 'is_verified'))->id;
                        $app_user = AppUser::find($app_user_id);
                        $app_user->password = Hash::make($password);
                        $app_user->save();

                        $this->error_code = 0;
                        $this->response = array('OTP' => $otp);

                    }
                } else {
                    $this->error_code = -104;
                }
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
